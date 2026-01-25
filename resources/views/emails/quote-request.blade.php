<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Solicitud de Cotización</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 650px;
            margin: 0 auto;
            padding: 0;
            background-color: #f4f4f4;
        }
        .email-container {
            background-color: #ffffff;
            margin: 20px auto;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 26px;
            font-weight: 600;
        }
        .header .icon {
            font-size: 48px;
            margin-bottom: 10px;
        }
        .alert-badge {
            background-color: #ef4444;
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
            margin-top: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .content {
            padding: 35px 30px;
        }
        .intro {
            background-color: #eff6ff;
            border-left: 4px solid #3b82f6;
            padding: 15px 20px;
            margin-bottom: 30px;
            border-radius: 4px;
            font-size: 15px;
            color: #1e40af;
        }
        .customer-info {
            background-color: #f9fafb;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            padding: 25px;
            margin-bottom: 25px;
        }
        .section-title {
            font-size: 16px;
            font-weight: 600;
            color: #1f2937;
            margin: 0 0 20px 0;
            padding-bottom: 10px;
            border-bottom: 2px solid #e5e7eb;
            display: flex;
            align-items: center;
        }
        .section-title .icon {
            margin-right: 8px;
            font-size: 20px;
        }
        .field {
            margin-bottom: 18px;
            display: flex;
            align-items: flex-start;
        }
        .field-label {
            font-weight: 600;
            color: #4b5563;
            min-width: 120px;
            font-size: 14px;
            padding-top: 2px;
        }
        .field-value {
            flex: 1;
            color: #1f2937;
            font-size: 14px;
            line-height: 1.6;
        }
        .field-value a {
            color: #3b82f6;
            text-decoration: none;
            font-weight: 500;
        }
        .field-value a:hover {
            text-decoration: underline;
        }
        .message-box {
            background-color: #ffffff;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            padding: 20px;
            margin-top: 25px;
            white-space: pre-wrap;
            word-wrap: break-word;
            line-height: 1.7;
            color: #374151;
            font-size: 14px;
        }
        .action-buttons {
            margin: 30px 0;
            text-align: center;
        }
        .btn {
            display: inline-block;
            padding: 14px 28px;
            margin: 5px 10px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
        }
        .btn-primary {
            background-color: #3b82f6;
            color: white;
        }
        .btn-primary:hover {
            background-color: #2563eb;
        }
        .btn-secondary {
            background-color: #10b981;
            color: white;
        }
        .btn-secondary:hover {
            background-color: #059669;
        }
        .metadata {
            background-color: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 15px 20px;
            margin-top: 25px;
            border-radius: 4px;
            font-size: 13px;
        }
        .metadata-item {
            margin: 5px 0;
            color: #78350f;
        }
        .metadata-label {
            font-weight: 600;
            display: inline-block;
            min-width: 100px;
        }
        .footer {
            background-color: #f9fafb;
            padding: 25px 30px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
            color: #6b7280;
            font-size: 13px;
        }
        .footer p {
            margin: 8px 0;
        }
        @media only screen and (max-width: 600px) {
            .content {
                padding: 25px 20px;
            }
            .header {
                padding: 25px 20px;
            }
            .field {
                flex-direction: column;
            }
            .field-label {
                margin-bottom: 5px;
            }
            .btn {
                display: block;
                margin: 10px 0;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <div class="icon">🔔</div>
            <h1>Nueva Solicitud de Cotización</h1>
            <div class="alert-badge">Acción Requerida</div>
        </div>

        <div class="content">
            <div class="intro">
                <strong>¡Atención!</strong> Has recibido una nueva solicitud de cotización.
                Revisa los detalles a continuación y contacta al cliente lo antes posible.
            </div>

            <div class="customer-info">
                <h2 class="section-title">
                    <span class="icon">👤</span>
                    Información del Cliente
                </h2>

                <div class="field">
                    <span class="field-label">Nombre:</span>
                    <span class="field-value"><strong>{{ $data['name'] }}</strong></span>
                </div>

                <div class="field">
                    <span class="field-label">Email:</span>
                    <span class="field-value">
                        <a href="mailto:{{ $data['email'] }}">{{ $data['email'] }}</a>
                    </span>
                </div>

                <div class="field">
                    <span class="field-label">Teléfono:</span>
                    <span class="field-value">
                        <a href="tel:{{ $data['phone'] }}">{{ $data['phone'] }}</a>
                    </span>
                </div>

                <div class="field">
                    <span class="field-label">Servicio:</span>
                    <span class="field-value"><strong style="color: #3b82f6;">{{ $data['service'] }}</strong></span>
                </div>

                @if(isset($data['submitted_at']))
                <div class="field">
                    <span class="field-label">Fecha/Hora:</span>
                    <span class="field-value">{{ $data['submitted_at'] }}</span>
                </div>
                @endif
            </div>

            <div class="customer-info">
                <h2 class="section-title">
                    <span class="icon">💬</span>
                    Mensaje del Cliente
                </h2>
                <div class="message-box">{{ $data['message'] }}</div>
            </div>

            <div class="action-buttons">
                <a href="mailto:{{ $data['email'] }}?subject=Re: Cotización {{ $data['service'] }}" class="btn btn-primary">
                    📧 Responder por Email
                </a>
                <a href="tel:{{ $data['phone'] }}" class="btn btn-secondary">
                    📞 Llamar Ahora
                </a>
            </div>

            @if(isset($data['ip_address']) || isset($data['user_agent']))
            <div class="metadata">
                <strong style="font-size: 14px; margin-bottom: 10px; display: block;">📊 Información Técnica</strong>
                @if(isset($data['ip_address']))
                <div class="metadata-item">
                    <span class="metadata-label">IP:</span>
                    <span>{{ $data['ip_address'] }}</span>
                </div>
                @endif
                @if(isset($data['user_agent']))
                <div class="metadata-item">
                    <span class="metadata-label">Navegador:</span>
                    <span style="font-size: 11px;">{{ Str::limit($data['user_agent'], 80) }}</span>
                </div>
                @endif
            </div>
            @endif
        </div>

        <div class="footer">
            <p><strong>💡 Consejo:</strong> Responde dentro de las primeras 24 horas para aumentar la tasa de conversión.</p>
            <p>Este correo fue generado automáticamente desde el formulario de cotización de tu sitio web.</p>
            <p>Puedes responder directamente usando el botón "Responder" o los enlaces de arriba.</p>
            @if($companyInfo && $companyInfo->name)
            <p style="margin-top: 20px; font-size: 12px; color: #9ca3af;">
                © {{ date('Y') }} {{ $companyInfo->name }}
            </p>
            @endif
        </div>
    </div>
</body>
</html>
