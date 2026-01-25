<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class QuoteConfirmationMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Nombre del cliente
     */
    public string $customerName;

    /**
     * Datos de la cotización
     */
    public array $quoteData;

    /**
     * Información de la empresa
     */
    public $companyInfo;

    /**
     * Create a new message instance.
     */
    public function __construct(string $customerName, array $quoteData, $companyInfo = null)
    {
        $this->customerName = $customerName;
        $this->quoteData = $quoteData;
        $this->companyInfo = $companyInfo;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $companyName = $this->companyInfo->name ?? config('app.name');

        return new Envelope(
            subject: '✅ Hemos recibido tu solicitud de cotización - ' . $companyName,
            tags: ['quote-confirmation'],
            metadata: [
                'customer_name' => $this->customerName,
            ],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.quote-confirmation',
            with: [
                'customerName' => $this->customerName,
                'data' => $this->quoteData,
                'companyInfo' => $this->companyInfo,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
