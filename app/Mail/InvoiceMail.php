<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvoiceMail extends Mailable
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
        return $this->view('emails.invoiceMail')
                    ->subject("【Quanto】請求書送信のお知らせ")
                    ->attach($this->invoicePdfFilePath);
    }
}
