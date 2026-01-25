<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Queue\SerializesModels;

class QuoteRequestMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Los datos de la cotización
     */
    public array $quoteData;

    /**
     * Información de la empresa
     */
    public $companyInfo;

    /**
     * Create a new message instance.
     */
    public function __construct(array $quoteData, $companyInfo = null)
    {
        $this->quoteData = $quoteData;
        $this->companyInfo = $companyInfo;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🔔 Nueva Solicitud de Cotización - ' . $this->quoteData['name'],
            replyTo: [
                new Address($this->quoteData['email'], $this->quoteData['name']),
            ],
            tags: ['quote-request'],
            metadata: [
                'service' => $this->quoteData['service'],
                'customer_email' => $this->quoteData['email'],
            ],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.quote-request',
            with: [
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
