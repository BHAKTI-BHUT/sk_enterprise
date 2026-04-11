<?php

namespace App\Mail;

use App\Models\Sale;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SaleInvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $sale;

    public function __construct(Sale $sale)
    {
        $this->sale = $sale;
    }

    public function build()
    {
        // Render the standalone printable invoice HTML
        $invoiceHtml = view('emails.invoice_attachment', ['sale' => $this->sale])->render();

        return $this
            ->subject('Invoice: ' . $this->sale->invoice_no . ' | Shree Krushna Enterprise')
            ->view('emails.invoice')
            ->attachData(
                $invoiceHtml,
                'Invoice_' . $this->sale->invoice_no . '.html',
                ['mime' => 'text/html']
            );
    }
}
