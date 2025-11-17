<?php

namespace App\Http\Controllers;

use App\Models\CompanyInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function index()
    {
        $companyInfo = CompanyInfo::first();

        return view('contact', compact('companyInfo'));
    }

    /**
     * Envía el mensaje de contacto por email
     */
    public function send(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'subject' => 'required|string|max:255',
                'message' => 'required|string|max:2000',
            ], [
                'name.required' => 'El nombre es obligatorio',
                'email.required' => 'El email es obligatorio',
                'email.email' => 'El email debe ser válido',
                'subject.required' => 'El asunto es obligatorio',
                'message.required' => 'El mensaje es obligatorio',
            ]);

            $companyInfo = CompanyInfo::first();
            $recipientEmail = $companyInfo->email ?? config('mail.from.address');

            Mail::send('emails.contact-message', ['data' => $validated], function ($message) use ($recipientEmail, $validated) {
                $message->to($recipientEmail)
                    ->subject('Nuevo Mensaje de Contacto - ' . $validated['subject'])
                    ->replyTo($validated['email'], $validated['name']);
            });

            return response()->json([
                'success' => true,
                'message' => 'Tu mensaje ha sido enviado correctamente. Te responderemos pronto.',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Por favor, completa todos los campos correctamente.',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error al enviar mensaje de contacto: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Hubo un error al enviar tu mensaje. Por favor, intenta nuevamente.',
            ], 500);
        }
    }
}