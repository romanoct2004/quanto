<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvoiceConfirmMail extends Mailable
{
    use Queueable, SerializesModels;

    public $clientName;
    public $senderName;
    public $data;
    public $invoicePdfFilePath;

    public function __construct($clientName, $senderName, $data, $invoicePdfFilePath)
    {
        $this->clientName = $clientName;
        $this->senderName = $senderName;
        $this->data = $data;
        $this->invoicePdfFilePath = $invoicePdfFilePath;
    }

    public function build()
    {
        return $this->view('emails.invoiceConfirmMail')
                    ->subject("【Quanto】請求書送信確認のお知らせ")
                    ->attach($this->invoicePdfFilePath);
    }
}
