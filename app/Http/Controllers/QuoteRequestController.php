<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Models\CompanyInfo;

class QuoteRequestController extends Controller
{
    /**
     * Envía una solicitud de cotización por email
     */
    public function send(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:50',
            'service' => 'required|string|max:255',
            'message' => 'required|string|max:1000',
        ], [
            'name.required' => 'El nombre es obligatorio',
            'email.required' => 'El email es obligatorio',
            'email.email' => 'El email debe ser válido',
            'phone.required' => 'El teléfono es obligatorio',
            'service.required' => 'El tipo de servicio es obligatorio',
            'message.required' => 'El mensaje es obligatorio',
        ]);

        try {
            $companyInfo = CompanyInfo::first();
            $recipientEmail = $companyInfo->email ?? config('mail.from.address');

            // Enviar email
            Mail::send('emails.quote-request', [
                'data' => $validated,
            ], function ($message) use ($recipientEmail, $validated) {
                $message->to($recipientEmail)
                    ->subject('Nueva Solicitud de Cotización - ' . $validated['name'])
                    ->replyTo($validated['email'], $validated['name']);
            });

            return response()->json([
                'success' => true,
                'message' => 'Su solicitud ha sido enviada correctamente. Nos pondremos en contacto pronto.',
            ]);

        } catch (\Exception $e) {
            Log::error('Error al enviar cotización: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Hubo un error al enviar su solicitud. Por favor, inténtelo nuevamente.',
            ], 500);
        }
    }
}
