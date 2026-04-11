@extends('partials.layouts.master')

@section('title', 'Tax Invoice #' . $sale->invoice_no)

@section('css')
<style>
    .invoice-box {
        max-width: 900px;
        margin: auto;
        padding: 15px;
        border: 1px solid #000;
        font-size: 13px;
        line-height: 18px;
        font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        color: #000;
        background: #fff;
    }

    .invoice-header {
        text-align: center;
        border-bottom: 2px solid #000;
        padding-bottom: 5px;
        margin-bottom: 10px;
    }

    .invoice-header h2 {
        margin: 0;
        font-size: 24px;
        text-transform: uppercase;
        font-weight: bold;
    }

    .info-table {
        width: 100%;
        border-collapse: collapse;
        border: 1px solid #000;
    }

    .info-table td {
        vertical-align: top;
        padding: 5px;
        border: 1px solid #000;
    }

    .tax-invoice-label {
        text-align: center;
        font-weight: bold;
        font-size: 16px;
        border-bottom: 1px solid #000;
        padding: 2px;
    }

    .items-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: -1px;
    }

    .items-table th, .items-table td {
        border: 1px solid #000;
        padding: 4px;
    }

    .items-table th {
        background: #f2f2f2;
        text-align: center;
        font-size: 12px;
    }

    .items-table td {
        height: 400px; /* Force minimum height for middle section */
        vertical-align: top;
    }

    .items-table tr.item-row td {
        height: auto;
    }

    .footer-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: -1px;
    }

    .footer-table td {
        border: 1px solid #000;
        padding: 5px;
        vertical-align: top;
    }

    .text-right { text-align: right; }
    .text-center { text-align: center; }
    .bold { font-weight: bold; }
    
    @media print {
        @page {
            size: A4;
            margin: 0;
        }
        body { margin: 1cm; background: #fff !important; }
        .d-print-none { display: none !important; }
        .invoice-box { 
            border: none !important; 
            box-shadow: none !important;
            width: 100% !important; 
            max-width: 100% !important; 
            padding: 0 !important;
            margin: 0 !important;
        }
    }
</style>
@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
    function downloadInvoice() {
        const element = document.getElementById('invoice-to-print');
        const opt = {
            margin:       0.2, // Approximately 5mm margin
            filename:     'Invoice_{{ $sale->invoice_no }}.pdf',
            image:        { type: 'jpeg', quality: 0.98 },
            html2canvas:  { scale: 2, useCORS: true },
            jsPDF:        { unit: 'in', format: 'a4', orientation: 'portrait' }
        };

        // For better rendering, hide buttons before capture
        html2pdf().set(opt).from(element).save();
    }
</script>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-12 text-end mb-3 d-print-none">
        <button onclick="downloadInvoice()" class="btn btn-primary"><i class="ri-file-download-line me-1"></i> Download PDF</button>
        <button onclick="window.print()" class="btn btn-soft-secondary"><i class="ri-printer-line me-1"></i> Print / Save</button>
        <a href="{{ route('sales.index') }}" class="btn btn-secondary">Back</a>
    </div>

    <div class="invoice-box" id="invoice-to-print">
        <div class="invoice-header">
            <h2>SHREE KRUSHNA ENTERPRISE</h2>
            <p class="mb-0">1- New Laxmi Soc. 150 Ft. Ring Road, Nr. Balaji Hall, Mavdi Plot, Rajkot.</p>
        </div>

        <div class="tax-invoice-label">TAX INVOICE</div>
        
        <table class="info-table">
            <tr>
                <td style="width: 60%;">
                    <span class="bold">M/s. : {{ $sale->customer->name }}</span><br>
                    {{ $sale->customer->address }}<br>
                    {{ $sale->customer->city }} - {{ $sale->customer->pincode }}<br>
                    <span class="bold">MO :</span> {{ $sale->customer->mobile }}<br>
                    <span class="bold">Place of Supply :</span> 24-Gujarat<br>
                    <span class="bold">GSTIN No. :</span> {{ $sale->customer->gst_number ?? 'N/A' }}
                </td>
                <td style="width: 40%; padding: 0;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <tr><td style="border:none; border-bottom:1px solid #000; padding:5px;"><span class="bold">Invoice No. :</span> {{ $sale->invoice_no }}</td></tr>
                        <tr><td style="border:none; border-bottom:1px solid #000; padding:5px;"><span class="bold">Date :</span> {{ date('d/m/Y', strtotime($sale->sale_date)) }}</td></tr>
                        <tr><td style="border:none; padding:5px;"><span class="bold">PO. NO. :</span> {{ $sale->notes }}</td></tr>
                    </table>
                </td>
            </tr>
        </table>

        <table class="items-table">
            <thead>
                <tr>
                    <th style="width: 5%;">SrNo</th>
                    <th style="width: 45%;">Product Name</th>
                    <th style="width: 10%;">HSN/SAC</th>
                    <th style="width: 8%;">Qty</th>
                    <th style="width: 12%;">Rate</th>
                    <th style="width: 8%;">GST %</th>
                    <th style="width: 12%;">Amount</th>
                </tr>
            </thead>
            <tbody>
                @php $totalQty = 0; @endphp
                @foreach($sale->items as $index => $item)
                @php $totalQty += $item->quantity; @endphp
                <tr class="item-row">
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $item->product->name }} <br><small>{{ $item->product->brand->name }}</small></td>
                    <td class="text-center">{{ $item->product->hsn_sac ?? '27101980' }}</td>
                    <td class="text-right">{{ number_format($item->quantity, 3) }}</td>
                    <td class="text-right">{{ number_format($item->unit_price, 2) }}</td>
                    <td class="text-center">{{ $item->tax_percentage }}%</td>
                    <td class="text-right">{{ number_format($item->total_amount, 2) }}</td>
                </tr>
                @endforeach
                
                {{-- Fill extra space to match design --}}
                <tr>
                    <td style="border-bottom:none;"></td>
                    <td style="border-bottom:none;"></td>
                    <td style="border-bottom:none;"></td>
                    <td style="border-bottom:none;"></td>
                    <td style="border-bottom:none;"></td>
                    <td style="border-bottom:none;"></td>
                    <td style="border-bottom:none;"></td>
                </tr>
            </tbody>
        </table>

        <table class="footer-table">
            <tr>
                <td colspan="4" style="width: 70%;">
                    <div class="bold">GSTIN No.: 24GIZPS9434M1ZY</div>
                    <div style="margin-top: 10px;">
                        <span class="bold">Bank Name :</span> IDFC FIRST BANK<br>
                        <span class="bold">Bank A/c. No. :</span> 10108735383<br>
                        <span class="bold">RTGS/IFSC Code :</span> IDFB0042425
                    </div>
                </td>
                <td colspan="3" style="width: 30%;">
                    <div class="d-flex justify-content-between">
                        <span class="bold">Sub Total</span>
                        <span class="bold">{{ number_format($sale->total_amount, 2) }}</span>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    <div class="bold">Total GST : <span style="font-weight: normal; font-style: italic;">{{ \App\Helpers\NumberToWords::convert($sale->tax_amount) }}</span></div>
                    <div class="bold mt-1">Bill Amount : <span style="font-weight: normal; font-style: italic;">{{ \App\Helpers\NumberToWords::convert($sale->payable_amount) }}</span></div>
                </td>
                <td colspan="3">
                    <div class="d-flex justify-content-between">
                        <span>Taxable Amount</span>
                        <span>{{ number_format($sale->total_amount, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Central Tax ({{ $sale->items->first()->tax_percentage / 2 }}%)</span>
                        <span>{{ number_format($sale->tax_amount / 2, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>State/UT Tax ({{ $sale->items->first()->tax_percentage / 2 }}%)</span>
                        <span>{{ number_format($sale->tax_amount / 2, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mt-2 border-top pt-1">
                        <span class="bold fs-14">Grand Total</span>
                        <span class="bold fs-14">{{ number_format($sale->payable_amount, 2) }}</span>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    <span class="bold">Note :</span> {{ $sale->notes }}
                </td>
                <td colspan="3" rowspan="2" class="text-center" style="vertical-align: bottom; height: 100px;">
                    <p class="mb-5">For, SHREE KRUSHNA ENTERPRISE</p>
                    <p class="bold mb-0 mt-5">(Authorised Signatory)</p>
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    <span class="bold">Terms & Condition :</span><br>
                    1. Goods once sold will not be taken back.<br>
                    2. Interest @18% p.a. will be charged if payment is not made within due date.<br>
                    3. Our risk and responsibility ceases as soon as the goods leave our premises.<br>
                    4. Subject to 'RAJKOT' Jurisdiction only. E. & O.E.
                </td>
            </tr>
        </table>
    </div>

    {{-- Footer Actions --}}
    <div class="col-12 mt-4 text-center d-print-none">
        <div class="hstack gap-3 justify-content-center">
            <button onclick="downloadInvoice()" class="btn btn-primary btn-lg shadow-sm">
                <i class="ri-file-download-line align-middle me-1"></i> Download PDF
            </button>
            
            <a href="{{ route('sales.email', $sale->id) }}" class="btn btn-info btn-lg text-white shadow-sm">
                <i class="ri-mail-send-line align-bottom me-1"></i> Send Business Email
            </a>
            
            <a href="https://wa.me/{{ $sale->customer->mobile }}?text=*SHREE KRUSHNA ENTERPRISE*%0A---- TAX INVOICE ----%0AInvoice No: *{{ $sale->invoice_no }}*%0ADate: {{ date('d-m-Y', strtotime($sale->sale_date)) }}%0A%0AHi {{ $sale->customer->name }}, your bill of *₹{{ number_format($sale->payable_amount, 2) }}* is ready.%0A%0A*Items:*%0A@foreach($sale->items as $item)- {{ $item->product->name }} (Qty: {{ $item->quantity }})%0A@endforeach%0A*Total Amount: ₹{{ number_format($sale->payable_amount, 2) }}*%0A%0A*Business Details:* %0ANr. Balaji Hall, Rajkot.%0AContact: Dharmik Patel (9512932626)%0A%0AThank you for your business!" target="_blank" class="btn btn-success btn-lg shadow-sm">
                <i class="ri-whatsapp-line align-bottom me-1"></i> Share via WhatsApp
            </a>
            
            <a href="{{ route('sales.index') }}" class="btn btn-outline-secondary btn-lg">Back to List</a>
        </div>
    </div>
</div>
@endsection
