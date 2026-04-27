<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'totalCustomers' => Customer::count(),
            'activeCustomers' => Customer::where('status', 1)->count(),
            'newCustomers' => Customer::where('created_at', '>=', now()->subDays(30))->count(),
            
            'totalProducts' => Product::count(),
            'activeProducts' => Product::where('status', 1)->count(),
            'outOfStock' => Product::where('stock_quantity', '<=', 0)->count(),
            
            'totalSalesAmount' => Sale::sum('total_amount'),
            'totalSalesCount' => Sale::count(),
            'recentSales' => Sale::with('customer')->latest()->take(5)->get(),
            
            'monthlySales' => Sale::selectRaw('SUM(total_amount) as total, MONTHNAME(sale_date) as month')
                ->where('sale_date', '>=', now()->subMonths(6))
                ->groupBy('month')
                ->orderBy('sale_date')
                ->get(),
        ];

        return view('dashboard', $data);
    }
}
