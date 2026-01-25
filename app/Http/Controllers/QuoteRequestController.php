<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use App\Models\CompanyInfo;
use App\Mail\QuoteRequestMail;
use App\Mail\QuoteConfirmationMail;

class QuoteRequestController extends Controller
{
    /**
     * Constructor - Aplica rate limiting al controlador
     */
    public function __construct()
    {
        // Limitar a 5 intentos por hora por IP
        $this->middleware('throttle:5,60')->only('send');
    }

    /**
     * Envía una solicitud de cotización por email
     *
     * Valida los datos, aplica rate limiting, envía email al admin
     * y confirmación automática al cliente
     */
    public function send(Request $request)
    {
        // Validaciones mejoradas
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'min:3',
                'max:255',
                'regex:/^[\pL\s\-]+$/u', // Solo letras, espacios y guiones
            ],
            'email' => [
                'required',
                'email:rfc,dns', // Validación estricta de email con DNS
                'max:255',
            ],
            'phone' => [
                'required',
                'string',
                'min:7',
                'max:50',
                'regex:/^[\d\s\+\-\(\)]+$/', // Solo números, espacios y caracteres de teléfono
            ],
            'service' => [
                'required',
                'string',
                'max:255',
            ],
            'message' => [
                'required',
                'string',
                'min:10',
                'max:2000',
            ],
        ], [
            // Mensajes personalizados en español
            'name.required' => 'El nombre es obligatorio',
            'name.min' => 'El nombre debe tener al menos 3 caracteres',
            'name.max' => 'El nombre no puede exceder 255 caracteres',
            'name.regex' => 'El nombre solo puede contener letras, espacios y guiones',

            'email.required' => 'El email es obligatorio',
            'email.email' => 'El email debe ser una dirección válida',
            'email.max' => 'El email no puede exceder 255 caracteres',

            'phone.required' => 'El teléfono es obligatorio',
            'phone.min' => 'El teléfono debe tener al menos 7 caracteres',
            'phone.max' => 'El teléfono no puede exceder 50 caracteres',
            'phone.regex' => 'El teléfono contiene caracteres no válidos',

            'service.required' => 'El tipo de servicio es obligatorio',
            'service.max' => 'El tipo de servicio no puede exceder 255 caracteres',

            'message.required' => 'El mensaje es obligatorio',
            'message.min' => 'El mensaje debe tener al menos 10 caracteres',
            'message.max' => 'El mensaje no puede exceder 2000 caracteres',
        ]);

        // Rate limiting adicional por email (evitar spam del mismo usuario)
        $emailKey = 'quote-request:' . $validated['email'];
        if (RateLimiter::tooManyAttempts($emailKey, 3)) {
            $seconds = RateLimiter::availableIn($emailKey);

            throw ValidationException::withMessages([
                'email' => "Demasiadas solicitudes desde este email. Por favor, intente nuevamente en " . ceil($seconds / 60) . " minutos.",
            ]);
        }

        // Agregar datos adicionales para seguridad y seguimiento
        $validated['ip_address'] = $request->ip();
        $validated['user_agent'] = $request->userAgent();
        $validated['submitted_at'] = now()->format('Y-m-d H:i:s');

        try {
            // Obtener información de la empresa
            $companyInfo = CompanyInfo::first();
            $recipientEmail = $companyInfo->email ?? config('mail.from.address');

            // Validar que hay un email destino configurado
            if (empty($recipientEmail)) {
                Log::error('No hay email de destino configurado para cotizaciones');

                return response()->json([
                    'success' => false,
                    'message' => 'El sistema de cotizaciones no está configurado correctamente. Por favor, contáctenos por otro medio.',
                ], 500);
            }

            // 1. Enviar email al administrador/empresa
            Mail::to($recipientEmail)->send(
                new QuoteRequestMail($validated, $companyInfo)
            );

            // 2. Enviar confirmación automática al cliente (si está habilitado)
            if (config('mail.send_customer_confirmation', true)) {
                Mail::to($validated['email'])->send(
                    new QuoteConfirmationMail(
                        $validated['name'],
                        $validated,
                        $companyInfo
                    )
                );
            }

            // Registrar el rate limit exitoso
            RateLimiter::hit($emailKey, 3600); // 1 hora

            // Log de cotización exitosa
            Log::info('Cotización enviada exitosamente', [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'service' => $validated['service'],
                'ip' => $validated['ip_address'],
            ]);

            return response()->json([
                'success' => true,
                'message' => config('mail.success_message', 'Su solicitud ha sido enviada correctamente. Nos pondremos en contacto pronto.'),
            ]);

        } catch (\Exception $e) {
            // Log detallado del error
            Log::error('Error al enviar cotización', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'data' => [
                    'name' => $validated['name'] ?? null,
                    'email' => $validated['email'] ?? null,
                    'ip' => $request->ip(),
                ],
            ]);

            // Mensaje genérico para el usuario (no exponer detalles técnicos)
            return response()->json([
                'success' => false,
                'message' => config('mail.error_message', 'Hubo un error al enviar su solicitud. Por favor, inténtelo nuevamente o contáctenos directamente.'),
            ], 500);
        }
    }
}
