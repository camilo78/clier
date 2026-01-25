<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Solicitud de Cotización</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 0;
            background-color: #f4f4f4;
        }
        .email-container {
            background-color: #ffffff;
            margin: 20px auto;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 600;
        }
        .header .icon {
            font-size: 48px;
            margin-bottom: 10px;
        }
        .content {
            padding: 40px 30px;
        }
        .greeting {
            font-size: 18px;
            color: #667eea;
            margin-bottom: 20px;
            font-weight: 600;
        }
        .message {
            font-size: 16px;
            line-height: 1.8;
            margin-bottom: 30px;
            color: #555;
        }
        .info-box {
            background-color: #f8f9ff;
            border-left: 4px solid #667eea;
            padding: 20px;
            margin: 30px 0;
            border-radius: 4px;
        }
        .info-box h3 {
            margin: 0 0 15px 0;
            color: #667eea;
            font-size: 16px;
            font-weight: 600;
        }
        .field {
            margin-bottom: 12px;
            font-size: 14px;
        }
        .field-label {
            font-weight: 600;
            color: #764ba2;
            display: inline-block;
            min-width: 100px;
        }
        .field-value {
            color: #555;
        }
        .next-steps {
            background-color: #fff9e6;
            border-left: 4px solid #ffc107;
            padding: 20px;
            margin: 30px 0;
            border-radius: 4px;
        }
        .next-steps h3 {
            margin: 0 0 15px 0;
            color: #f57c00;
            font-size: 16px;
            font-weight: 600;
        }
        .next-steps ul {
            margin: 0;
            padding-left: 20px;
            color: #666;
        }
        .next-steps li {
            margin-bottom: 8px;
        }
        .contact-info {
            background-color: #f0f0f0;
            padding: 20px;
            margin: 30px 0;
            border-radius: 4px;
            text-align: center;
        }
        .contact-info h3 {
            margin: 0 0 15px 0;
            color: #333;
            font-size: 16px;
        }
        .contact-item {
            display: inline-block;
            margin: 5px 15px;
            font-size: 14px;
        }
        .contact-item a {
            color: #667eea;
            text-decoration: none;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #e9ecef;
            color: #6c757d;
            font-size: 14px;
        }
        .footer p {
            margin: 5px 0;
        }
        .footer a {
            color: #667eea;
            text-decoration: none;
        }
        @media only screen and (max-width: 600px) {
            .content {
                padding: 30px 20px;
            }
            .header {
                padding: 30px 20px;
            }
            .header h1 {
                font-size: 24px;
            }
            .contact-item {
                display: block;
                margin: 10px 0;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <div class="icon">✅</div>
            <h1>¡Solicitud Recibida!</h1>
        </div>

        <div class="content">
            <div class="greeting">
                Hola {{ $customerName }},
            </div>

            <div class="message">
                <p>Hemos recibido tu solicitud de cotización y queremos agradecerte por contactarnos.</p>
                <p>Nuestro equipo revisará tu solicitud y se pondrá en contacto contigo a la brevedad posible.</p>
            </div>

            <div class="info-box">
                <h3>📋 Resumen de tu Solicitud</h3>
                <div class="field">
                    <span class="field-label">Servicio:</span>
                    <span class="field-value">{{ $data['service'] }}</span>
                </div>
                <div class="field">
                    <span class="field-label">Email:</span>
                    <span class="field-value">{{ $data['email'] }}</span>
                </div>
                <div class="field">
                    <span class="field-label">Teléfono:</span>
                    <span class="field-value">{{ $data['phone'] }}</span>
                </div>
                @if(isset($data['submitted_at']))
                <div class="field">
                    <span class="field-label">Fecha:</span>
                    <span class="field-value">{{ $data['submitted_at'] }}</span>
                </div>
                @endif
            </div>

            <div class="next-steps">
                <h3>⏳ ¿Qué sigue ahora?</h3>
                <ul>
                    <li>Nuestro equipo revisará tu solicitud en las próximas 24-48 horas</li>
                    <li>Te contactaremos por email o teléfono para discutir los detalles</li>
                    <li>Prepararemos una cotización personalizada para ti</li>
                    <li>Resolveremos cualquier duda que puedas tener</li>
                </ul>
            </div>

            @if($companyInfo && ($companyInfo->email || $companyInfo->phone))
            <div class="contact-info">
                <h3>¿Necesitas ayuda inmediata?</h3>
                @if($companyInfo->email)
                <div class="contact-item">
                    📧 <a href="mailto:{{ $companyInfo->email }}">{{ $companyInfo->email }}</a>
                </div>
                @endif
                @if($companyInfo->phone)
                <div class="contact-item">
                    📞 <a href="tel:{{ $companyInfo->phone }}">{{ $companyInfo->phone }}</a>
                </div>
                @endif
            </div>
            @endif

            <div class="message" style="margin-top: 30px;">
                <p style="margin-bottom: 5px;"><strong>Gracias por tu confianza,</strong></p>
                <p style="color: #667eea; font-weight: 600; margin: 0;">
                    {{ $companyInfo->name ?? config('app.name') }}
                </p>
            </div>
        </div>

        <div class="footer">
            <p>Este es un correo automático de confirmación. Por favor, no respondas a este mensaje.</p>
            @if($companyInfo && $companyInfo->email)
            <p>Para cualquier consulta, escríbenos a <a href="mailto:{{ $companyInfo->email }}">{{ $companyInfo->email }}</a></p>
            @endif
            <p style="margin-top: 20px; font-size: 12px; color: #999;">
                © {{ date('Y') }} {{ $companyInfo->name ?? config('app.name') }}. Todos los derechos reservados.
            </p>
        </div>
    </div>
</body>
</html>
