<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $sale->invoice_no }} | Shree Krushna Enterprise</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Arial', sans-serif; font-size: 13px; color: #000; background: #fff; }
        .invoice-box { max-width: 850px; margin: 20px auto; padding: 20px; border: 1px solid #000; }
        .invoice-header { text-align: center; border-bottom: 2px solid #000; padding-bottom: 8px; margin-bottom: 8px; }
        .invoice-header h2 { font-size: 22px; text-transform: uppercase; font-weight: bold; margin-bottom: 3px; }
        .invoice-header p { font-size: 12px; }
        .tax-invoice-label { text-align: center; font-weight: bold; font-size: 15px; border: 1px solid #000; border-top: none; padding: 3px; margin-bottom: -1px; }
        .info-table { width: 100%; border-collapse: collapse; border: 1px solid #000; }
        .info-table td { vertical-align: top; padding: 6px 8px; border: 1px solid #000; font-size: 12px; }
        .bold { font-weight: bold; }
        .items-table { width: 100%; border-collapse: collapse; margin-top: -1px; }
        .items-table th { border: 1px solid #000; padding: 5px 6px; text-align: center; background-color: #f2f2f2; font-size: 12px; }
        .items-table td { border: 1px solid #000; padding: 5px 6px; font-size: 12px; }
        .items-table td.text-right { text-align: right; }
        .items-table td.text-center { text-align: center; }
        .footer-table { width: 100%; border-collapse: collapse; margin-top: -1px; }
        .footer-table td { border: 1px solid #000; padding: 6px 8px; vertical-align: top; font-size: 12px; }
        .total-row { display: flex; justify-content: space-between; padding: 3px 0; }
        .spacer-row td { height: 200px; vertical-align: top; }
        .print-note { text-align: center; color: #555; font-size: 11px; margin-top: 20px; padding: 10px; background: #f9f9f9; border: 1px dashed #ccc; }
        @media print {
            @page { size: A4; margin: 10mm; }
            body { margin: 0; }
            .invoice-box { margin: 0; border: none; padding: 0; max-width: 100%; }
            .print-note { display: none; }
        }
    </style>
</head>
<body>
    <div class="invoice-box">
        <div class="invoice-header">
            <h2>SHREE KRUSHNA ENTERPRISE</h2>
            <p>Exclusive Oil Traders | 1- New Laxmi Soc. 150 Ft. Ring Road, Nr. Balaji Hall, Mavdi Plot, Rajkot.</p>
            <p>GSTIN: 24GIZPS9434M1ZY | Ph: +91 95129 32626 | Email: shreekrishnaenterprise@gmail.com</p>
        </div>

        <div class="tax-invoice-label">TAX INVOICE</div>

        <table class="info-table">
            <tr>
                <td style="width: 60%;">
                    <div class="bold">M/s.: {{ $sale->customer->name }}</div>
                    <div>{{ $sale->customer->address }}</div>
                    <div>{{ $sale->customer->city }} - {{ $sale->customer->pincode }}</div>
                    <div><span class="bold">MO:</span> {{ $sale->customer->mobile }}</div>
                    <div><span class="bold">Place of Supply:</span> 24-Gujarat</div>
                    <div><span class="bold">GSTIN No.:</span> {{ $sale->customer->gst_number ?? 'N/A' }}</div>
                </td>
                <td style="width: 40%; padding: 0;">
                    <table style="width:100%; border-collapse:collapse;">
                        <tr><td style="border:none; border-bottom:1px solid #000; padding:6px 8px;"><span class="bold">Invoice No.:</span> {{ $sale->invoice_no }}</td></tr>
                        <tr><td style="border:none; border-bottom:1px solid #000; padding:6px 8px;"><span class="bold">Date:</span> {{ date('d/m/Y', strtotime($sale->sale_date)) }}</td></tr>
                        <tr><td style="border:none; border-bottom:1px solid #000; padding:6px 8px;"><span class="bold">Payment Mode:</span> {{ $sale->payment_method }}</td></tr>
                        <tr><td style="border:none; padding:6px 8px;"><span class="bold">PO/Ref.:</span> {{ $sale->notes ?? '-' }}</td></tr>
                    </table>
                </td>
            </tr>
        </table>

        <table class="items-table">
            <thead>
                <tr>
                    <th style="width:5%;">Sr.</th>
                    <th style="width:40%;">Product Name</th>
                    <th style="width:10%;">HSN/SAC</th>
                    <th style="width:8%;">Qty</th>
                    <th style="width:12%;">Rate (₹)</th>
                    <th style="width:8%;">GST %</th>
                    <th style="width:12%;">Amount (₹)</th>
                </tr>
            </thead>
            <tbody>
                @php $totalQty = 0; @endphp
                @foreach($sale->items as $index => $item)
                @php $totalQty += $item->quantity; @endphp
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $item->product->name }}<br><small style="color:#555;">{{ $item->product->brand->name }}</small></td>
                    <td class="text-center">{{ $item->product->hsn_sac ?? '27101980' }}</td>
                    <td class="text-right">{{ number_format($item->quantity, 3) }}</td>
                    <td class="text-right">{{ number_format($item->unit_price, 2) }}</td>
                    <td class="text-center">{{ $item->tax_percentage }}%</td>
                    <td class="text-right">{{ number_format($item->total_amount, 2) }}</td>
                </tr>
                @endforeach
                {{-- spacer --}}
                <tr class="spacer-row">
                    <td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                </tr>
            </tbody>
        </table>

        <table class="footer-table">
            <tr>
                <td style="width:60%;">
                    <div class="bold">GSTIN No.: 24GIZPS9434M1ZY</div>
                    <div style="margin-top:8px;">
                        <span class="bold">Bank Name:</span> IDFC FIRST BANK<br>
                        <span class="bold">A/c No.:</span> 10108735383<br>
                        <span class="bold">RTGS/IFSC:</span> IDFB0042425
                    </div>
                </td>
                <td style="width:40%;">
                    <div class="total-row"><span>Sub Total</span><span>₹{{ number_format($sale->total_amount, 2) }}</span></div>
                    <div class="total-row"><span>Taxable Amount</span><span>₹{{ number_format($sale->total_amount, 2) }}</span></div>
                    <div class="total-row"><span>Central Tax ({{ $sale->items->first()->tax_percentage / 2 }}%)</span><span>₹{{ number_format($sale->tax_amount / 2, 2) }}</span></div>
                    <div class="total-row"><span>State/UT Tax ({{ $sale->items->first()->tax_percentage / 2 }}%)</span><span>₹{{ number_format($sale->tax_amount / 2, 2) }}</span></div>
                    @if($sale->discount_amount > 0)
                    <div class="total-row" style="color:#c00;"><span>Discount</span><span>-₹{{ number_format($sale->discount_amount, 2) }}</span></div>
                    @endif
                    <div class="total-row bold" style="border-top:2px solid #000; margin-top:5px; padding-top:5px; font-size:14px;">
                        <span>Grand Total</span><span>₹{{ number_format($sale->payable_amount, 2) }}</span>
                    </div>
                    <div class="total-row" style="color:#c00;"><span>Due Balance</span><span>₹{{ number_format($sale->due_amount, 2) }}</span></div>
                </td>
            </tr>
            <tr>
                <td>
                    <span class="bold">Total GST:</span> ₹{{ number_format($sale->tax_amount, 2) }}<br>
                    <span class="bold">Bill Amount:</span> ₹{{ number_format($sale->payable_amount, 2) }}
                </td>
                <td colspan="1"></td>
            </tr>
            <tr>
                <td>
                    <span class="bold">Note:</span> {{ $sale->notes ?? '-' }}
                </td>
                <td style="text-align:center; vertical-align:bottom; height:80px;">
                    <div>For, SHREE KRUSHNA ENTERPRISE</div>
                    <br><br>
                    <div class="bold">(Authorised Signatory)</div>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <span class="bold">Terms &amp; Conditions:</span><br>
                    1. Goods once sold will not be taken back.<br>
                    2. Interest @18% p.a. will be charged if payment is not made within due date.<br>
                    3. Our risk and responsibility ceases as soon as the goods leave our premises.<br>
                    4. Subject to 'RAJKOT' Jurisdiction only. E. &amp; O.E.
                </td>
            </tr>
        </table>
    </div>

    <div class="print-note">
        📄 To save as PDF: Press <strong>Ctrl+P</strong> → Select <strong>"Save as PDF"</strong> → Click Save<br>
        For queries: <strong>+91 95129 32626</strong> | <strong>shreekrishnaenterprise@gmail.com</strong>
    </div>
</body>
</html>
