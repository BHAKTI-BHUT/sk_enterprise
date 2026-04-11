<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f7f6; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 20px auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        .header { background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); color: #ffffff; padding: 30px; text-align: center; }
        .header h1 { margin: 0; font-size: 24px; text-transform: uppercase; letter-spacing: 1px; }
        .header p { margin: 5px 0 0; opacity: 0.8; font-size: 14px; }
        .content { padding: 30px; }
        .greeting { font-size: 18px; color: #333; margin-bottom: 10px; }
        .invoice-details { background-color: #f8f9fa; border-radius: 6px; padding: 15px; margin-bottom: 25px; border-left: 4px solid #1e3c72; }
        .invoice-details table { width: 100%; border-collapse: collapse; }
        .invoice-details td { padding: 5px 0; color: #555; font-size: 14px; }
        .invoice-details .label { font-weight: bold; color: #333; width: 40%; }
        .items-table { width: 100%; border-collapse: collapse; margin-bottom: 25px; }
        .items-table th { border-bottom: 2px solid #eee; padding: 12px 5px; text-align: left; font-size: 13px; color: #777; text-transform: uppercase; }
        .items-table td { border-bottom: 1px solid #eee; padding: 12px 5px; font-size: 14px; color: #444; }
        .total-section { float: right; width: 100%; margin-top: 10px; }
        .total-row { display: flex; justify-content: space-between; padding: 5px 0; font-size: 15px; }
        .grand-total { font-size: 20px; color: #1e3c72; font-weight: bold; border-top: 2px solid #1e3c72; padding-top: 10px; margin-top: 5px; }
        .footer { background-color: #2b2d42; color: #ffffff; padding: 25px; text-align: center; }
        .footer h3 { margin: 0 0 10px; font-size: 16px; color: #8d99ae; }
        .footer p { margin: 3px 0; font-size: 13px; color: #edf2f4; opacity: 0.8; }
        .contact-card { margin-top: 15px; display: inline-block; background: rgba(255,255,255,0.1); padding: 10px 20px; border-radius: 30px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>SHREE KRUSHNA ENTERPRISE</h1>
            <p>Exclusive Oil Traders</p>
        </div>
        <div class="content">
            <p class="greeting">Hi {{ $sale->customer->name }},</p>
            <p>Thank you for choosing us! Here are the details of your recent purchase.</p>
            
            <div class="invoice-details">
                <table>
                    <tr><td class="label">Invoice No:</td><td>{{ $sale->invoice_no }}</td></tr>
                    <tr><td class="label">Date:</td><td>{{ date('d-M-Y', strtotime($sale->sale_date)) }}</td></tr>
                    <tr><td class="label">Customer GST:</td><td>{{ $sale->customer->gst_number ?? 'N/A' }}</td></tr>
                </table>
            </div>

            <table class="items-table">
                <thead>
                    <tr>
                        <th style="width: 50%;">Product Details</th>
                        <th style="text-align: center;">Qty</th>
                        <th style="text-align: right;">Amount (₹)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sale->items as $item)
                    <tr>
                        <td>
                            <div style="font-weight: bold;">{{ $item->product->name }}</div>
                            <div style="font-size: 12px; color: #888;">{{ $item->product->brand->name }} | HSN: {{ $item->product->hsn_sac ?? '2710' }}</div>
                        </td>
                        <td style="text-align: center;">{{ $item->quantity }}</td>
                        <td style="text-align: right;">{{ number_format($item->total_amount, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="total-section">
                <div style="max-width: 250px; margin-left: auto;">
                    <div class="total-row"><span>Sub Total:</span><span>₹{{ number_format($sale->total_amount, 2) }}</span></div>
                    <div class="total-row"><span>Tax (GST):</span><span>₹{{ number_format($sale->tax_amount, 2) }}</span></div>
                    @if($sale->discount_amount > 0)
                        <div class="total-row" style="color: #e63946;"><span>Discount:</span><span>- ₹{{ number_format($sale->discount_amount, 2) }}</span></div>
                    @endif
                    <div class="grand-total total-row">
                        <span>Total Payable:</span>
                        <span>₹{{ number_format($sale->payable_amount, 2) }}</span>
                    </div>
                </div>
            </div>
            
            <div style="clear: both; margin-top: 40px; padding: 20px; background-color: #f0f7ff; border-radius: 8px; text-align: center;">
                <p style="margin: 0; color: #1e3c72; font-weight: bold; font-size: 15px;">Have any questions or concerns?</p>
                <p style="margin: 5px 0 0; color: #555; font-size: 14px;">Please feel free to reach out to us. We're here to help!</p>
            </div>
        </div>
        <div class="footer">
            <h3>SHREE KRUSHNA ENTERPRISE</h3>
            <p>Exclusive Oil Traders | Rajkot, Gujarat.</p>
            <div class="contact-card">
                <p style="opacity: 1; font-weight: bold; margin-bottom: 5px;">Contact: +91 95129 32626</p>
                <p style="opacity: 1; margin: 0; font-size: 13px;">Email: shreeskrushnaent2626@gmail.com</p>
            </div>
            <p style="margin-top: 15px; font-size: 11px; opacity: 0.6;">&copy; {{ date('Y') }} Shree Krushna Enterprise. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
