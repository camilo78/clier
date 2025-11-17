<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Solicitud de Cotización</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #007bff;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            background-color: #f8f9fa;
            padding: 30px;
            border: 1px solid #dee2e6;
        }
        .field {
            margin-bottom: 20px;
        }
        .field-label {
            font-weight: bold;
            color: #007bff;
            display: block;
            margin-bottom: 5px;
        }
        .field-value {
            background-color: white;
            padding: 10px;
            border-radius: 3px;
            border: 1px solid #dee2e6;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #dee2e6;
            color: #6c757d;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Nueva Solicitud de Cotización</h1>
    </div>

    <div class="content">
        <p>Has recibido una nueva solicitud de cotización con los siguientes datos:</p>

        <div class="field">
            <span class="field-label">Nombre:</span>
            <div class="field-value">{{ $data['name'] }}</div>
        </div>

        <div class="field">
            <span class="field-label">Email:</span>
            <div class="field-value">
                <a href="mailto:{{ $data['email'] }}">{{ $data['email'] }}</a>
            </div>
        </div>

        <div class="field">
            <span class="field-label">Teléfono:</span>
            <div class="field-value">{{ $data['phone'] }}</div>
        </div>

        <div class="field">
            <span class="field-label">Tipo de Servicio:</span>
            <div class="field-value">{{ $data['service'] }}</div>
        </div>

        <div class="field">
            <span class="field-label">Mensaje:</span>
            <div class="field-value">{{ $data['message'] }}</div>
        </div>
    </div>

    <div class="footer">
        <p>Este es un correo automático generado desde el formulario de cotización del sitio web.</p>
        <p>Por favor, responde directamente al cliente usando el botón "Responder" de tu cliente de correo.</p>
    </div>
</body>
</html>
