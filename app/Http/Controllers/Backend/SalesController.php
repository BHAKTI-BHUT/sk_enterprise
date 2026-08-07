<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\CustomerLedger;
use App\Mail\SaleInvoiceMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Notifications\LowStockNotification;
use Illuminate\Support\Facades\Notification;

class SalesController extends Controller
{
    /**
     * Display a listing of sales.
     */
    public function index()
    {
        $sales = Sale::with('customer')->orderBy('sale_date', 'desc')->get();
        return view('backend.sales.index', compact('sales'));
    }

    /**
     * Show the form for creating a new sale.
     */
    public function create()
    {
        $customers = Customer::where('status', 'active')->get();
        $products = Product::with('brand')->where('status', 'active')->get();
        
        // Generate Invoice Number (Format: INV-2026-0001)
        $lastSale = Sale::orderBy('id', 'desc')->first();
        $lastId = $lastSale ? $lastSale->id : 0;
        $invoiceNo = 'INV-' . date('Y') . '-' . str_pad($lastId + 1, 4, '0', STR_PAD_LEFT);

        return view('backend.sales.create', compact('customers', 'products', 'invoiceNo'));
    }

    /**
     * Store a newly created sale in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'sale_date' => 'required|date',
            'products' => 'required|array|min:1',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|numeric|min:0.01',
            'products.*.price' => 'required|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            // 1. Calculate Totals
            $totalAmount = 0;
            $taxAmount = 0;
            $payableAmount = 0;
            
            foreach ($request->products as $item) {
                $product = Product::find($item['id']);
                
                // Stock Validation
                if ($product->stock_quantity < $item['quantity']) {
                    return back()->with('error', "Stock unavailable for {$product->name}. (Available: {$product->stock_quantity}, Requested: {$item['quantity']})")->withInput();
                }

                $itemTotal = $item['quantity'] * $item['price'];
                $itemTax = ($itemTotal * $product->gst_percentage) / 100;
                
                $totalAmount += $itemTotal;
                $taxAmount += $itemTax;
            }

            $discountAmount = $request->discount_amount ?? 0;
            $payableAmount = ($totalAmount + $taxAmount) - $discountAmount;
            $paidAmount = $request->paid_amount ?? 0;
            $dueAmount = $payableAmount - $paidAmount;
            
            $paymentStatus = 'unpaid';
            if ($paidAmount >= $payableAmount) {
                $paymentStatus = 'paid';
            } elseif ($paidAmount > 0) {
                $paymentStatus = 'partial';
            }

            // Generate Invoice No again to be safe in high traffic (though unlikely here)
            $lastSale = Sale::orderBy('id', 'desc')->first();
            $lastId = $lastSale ? $lastSale->id : 0;
            $invoiceNo = 'INV-' . date('Y') . '-' . str_pad($lastId + 1, 4, '0', STR_PAD_LEFT);

            // 2. Create Sale Header
            $sale = Sale::create([
                'invoice_no' => $invoiceNo,
                'customer_id' => $request->customer_id,
                'sale_date' => $request->sale_date,
                'total_amount' => $totalAmount,
                'tax_amount' => $taxAmount,
                'discount_amount' => $discountAmount,
                'payable_amount' => $payableAmount,
                'paid_amount' => $paidAmount,
                'due_amount' => $dueAmount,
                'payment_status' => $paymentStatus,
                'payment_method' => $request->payment_method,
                'notes' => $request->notes,
                'created_by' => Auth::id(),
            ]);

            // 3. Create Sale Items & Update Stock
            foreach ($request->products as $item) {
                $product = Product::find($item['id']);
                $itemTotal = $item['quantity'] * $item['price'];
                $itemTax = ($itemTotal * $product->gst_percentage) / 100;

                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['price'],
                    'tax_percentage' => $product->gst_percentage,
                    'tax_amount' => $itemTax,
                    'total_amount' => $itemTotal + $itemTax,
                ]);

                // Update Stock
                $product->decrement('stock_quantity', $item['quantity']);

                // 3a. Check for Low Stock Notification
                $product->refresh(); // Get updated stock
                if ($product->stock_quantity <= $product->min_stock_alert) {
                    $admin = User::role('admin')->first() ?? User::first();
                    if ($admin) {
                        Notification::send($admin, new LowStockNotification($product));
                    }
                }
            }

            // 4. Update Customer Ledger (Record the Sale as Debit)
            $customer = Customer::find($request->customer_id);
            $currentBalance = $customer->current_outstanding;
            $balanceAfterSale = $currentBalance + $payableAmount;

            CustomerLedger::create([
                'customer_id' => $request->customer_id,
                'transaction_date' => $request->sale_date,
                'transaction_type' => 'sale',
                'reference_no' => $invoiceNo,
                'debit' => $payableAmount,
                'credit' => 0,
                'balance' => $balanceAfterSale,
                'description' => 'Invoice No: ' . $invoiceNo,
            ]);

            // 5. If any amount was paid, update ledger again (Record Payment as Credit)
            if ($paidAmount > 0) {
                $balanceAfterPayment = $balanceAfterSale - $paidAmount;
                CustomerLedger::create([
                    'customer_id' => $request->customer_id,
                    'transaction_date' => $request->sale_date,
                    'transaction_type' => 'payment',
                    'reference_no' => 'PAY-' . $invoiceNo,
                    'debit' => 0,
                    'credit' => $paidAmount,
                    'balance' => $balanceAfterPayment,
                    'description' => 'Payment received for ' . $invoiceNo,
                ]);
            }

            // 6. Update Customer Outstanding
            $customer->increment('current_outstanding', $dueAmount);

            DB::commit();

            // *** Automatic Email Sending ***
            if ($customer->email) {
                try {
                    Mail::to($customer->email)->send(new SaleInvoiceMail($sale));
                } catch (\Exception $e) {
                    // Fail silently or log error if mail not configured, but save the sale
                }
            }

            return redirect()->route('sales.show', $sale->id)->with('success', 'Sale recorded successfully! Invoice generated and sent to ' . ($customer->email ?? 'customer'));

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified sale.
     */
    public function show($id)
    {
        $sale = Sale::with(['customer', 'items.product', 'creator'])->findOrFail($id);
        return view('backend.sales.show', compact('sale'));
    }

    public function sendEmail($id)
    {
        $sale = Sale::with(['customer', 'items.product'])->findOrFail($id);
        
        if (!$sale->customer->email) {
            return back()->with('error', 'Customer email not found.');
        }

        try {
            Mail::to($sale->customer->email)->send(new SaleInvoiceMail($sale));
            return back()->with('success', 'Invoice emailed successfully to ' . $sale->customer->email);
        } catch (\Exception $e) {
            return back()->with('error', 'Mail Error: ' . $e->getMessage());
        }
    }
}
