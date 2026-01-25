# 📧 Módulo de Cotizaciones por Email - Documentación Completa

## 🎯 Descripción General

Sistema completo de envío de cotizaciones por email con las siguientes características:

✅ **Validaciones robustas** del lado del servidor y cliente
✅ **Rate limiting** anti-spam (5 envíos por hora por IP)
✅ **Emails profesionales** con diseño responsive
✅ **Confirmación automática** al cliente
✅ **Logging detallado** de todas las operaciones
✅ **Cola de emails** para mejor rendimiento
✅ **Manejo de errores** completo y amigable

---

## 📁 Estructura de Archivos

```
app/
├── Http/Controllers/
│   └── QuoteRequestController.php       # Controlador mejorado con validaciones y rate limiting
├── Mail/
│   ├── QuoteRequestMail.php             # Email para el administrador
│   └── QuoteConfirmationMail.php        # Email de confirmación al cliente

resources/views/
├── emails/
│   ├── quote-request.blade.php          # Template para admin (diseño profesional)
│   └── quote-confirmation.blade.php     # Template para cliente (diseño profesional)
└── home.blade.php                        # Formulario con JavaScript mejorado

config/
└── mail.php                              # Configuración personalizada

.env.example.mail                         # Guía de configuración para diferentes proveedores
```

---

## 🚀 Características Implementadas

### 1. **Validaciones Mejoradas**

#### Lado del Servidor (PHP)
- Nombre: mínimo 3 caracteres, solo letras
- Email: validación estricta con DNS
- Teléfono: mínimo 7 caracteres, formato válido
- Servicio: obligatorio
- Mensaje: mínimo 10 caracteres, máximo 2000

#### Lado del Cliente (JavaScript)
- Validación en tiempo real
- Feedback visual inmediato
- Prevención de envíos múltiples

### 2. **Seguridad Anti-Spam**

#### Rate Limiting por IP
- Máximo 5 envíos por hora
- Configurado via middleware `throttle:5,60`

#### Rate Limiting por Email
- Máximo 3 envíos por hora del mismo email
- Implementado con `RateLimiter::tooManyAttempts()`

### 3. **Sistema de Emails**

#### Email al Administrador
**Características:**
- Diseño profesional con gradientes
- Badge de "Acción Requerida"
- Botones de acción directa (Email, Llamar)
- Información técnica (IP, User Agent)
- Responsive para móviles

**Incluye:**
- Datos completos del cliente
- Mensaje del cliente en formato legible
- Enlaces para responder directamente
- Metadata para tracking

#### Email de Confirmación al Cliente
**Características:**
- Diseño amigable y profesional
- Resumen de la solicitud
- Información sobre próximos pasos
- Datos de contacto de la empresa
- Responsive para móviles

**Incluye:**
- Saludo personalizado
- Resumen de lo enviado
- Timeline de qué esperar
- Información de contacto

### 4. **Manejo de Errores**

#### Errores Capturados
- Validación fallida (422)
- Rate limiting (429)
- Errores del servidor (500)
- Errores de conexión

#### Logging
- Éxitos registrados en `laravel.log`
- Errores con stack trace completo
- Información contextual (IP, email, servicio)

### 5. **Mejoras UX del Formulario**

- Spinner de carga durante el envío
- Mensajes de éxito/error con íconos
- Auto-scroll al mensaje
- Reseteo automático tras éxito
- Auto-ocultamiento de mensajes de éxito
- Validación visual en tiempo real

---

## ⚙️ Configuración

### Paso 1: Configurar SMTP

Edita tu archivo `.env` con uno de estos proveedores:

#### GMAIL (Recomendado para desarrollo)
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=tucorreo@gmail.com
MAIL_PASSWORD=xxxx_xxxx_xxxx_xxxx  # Contraseña de aplicación
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="tucorreo@gmail.com"
MAIL_FROM_NAME="Tu Empresa"
```

**⚠️ IMPORTANTE para Gmail:**
1. Activa verificación en 2 pasos
2. Genera una "Contraseña de aplicación" en https://myaccount.google.com/security
3. Usa esa contraseña (NO tu contraseña normal)

#### SENDGRID (Recomendado para producción)
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.sendgrid.net
MAIL_PORT=587
MAIL_USERNAME=apikey
MAIL_PASSWORD=SG.xxxxxxxxxxxxxxxxx  # Tu API Key
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@tudominio.com"
MAIL_FROM_NAME="Tu Empresa"
```

#### HOSTING (cPanel/Hostinger)
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.tudominio.com
MAIL_PORT=465
MAIL_USERNAME=contacto@tudominio.com
MAIL_PASSWORD=tu_password
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS="contacto@tudominio.com"
MAIL_FROM_NAME="Tu Empresa"
```

### Paso 2: Configurar Email de Destino

**Opción A: Via Base de Datos**
```sql
UPDATE company_infos SET email = 'tucorreo@gmail.com' WHERE id = 1;
```

**Opción B: Via Panel Admin**
1. Ve a `/admin/cms/company-info`
2. Edita el campo "Email"
3. Guarda

### Paso 3: Configuraciones Opcionales

Agrega estas líneas a tu `.env` para personalizar:

```env
# Enviar confirmación automática al cliente (true/false)
MAIL_SEND_CUSTOMER_CONFIRMATION=true

# Mensaje personalizado de éxito
MAIL_SUCCESS_MESSAGE="Su solicitud ha sido enviada correctamente. Nos pondremos en contacto pronto."

# Mensaje personalizado de error
MAIL_ERROR_MESSAGE="Hubo un error al enviar su solicitud. Por favor, inténtelo nuevamente."
```

### Paso 4: Limpiar Cache

```bash
php artisan config:clear
php artisan cache:clear
```

---

## 🧪 Pruebas

### 1. Probar con Mailtrap (Recomendado para testing)

```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=tu_username
MAIL_PASSWORD=tu_password
MAIL_ENCRYPTION=tls
```

Regístrate en https://mailtrap.io y obtén las credenciales.

### 2. Probar desde el Formulario

1. Ve a tu página home
2. Llena el formulario
3. Envía
4. Deberías ver un mensaje de éxito
5. Revisa tu bandeja de entrada

### 3. Probar desde Tinker

```bash
php artisan tinker
```

```php
use App\Mail\QuoteRequestMail;
use Illuminate\Support\Facades\Mail;

$data = [
    'name' => 'Test User',
    'email' => 'test@example.com',
    'phone' => '123456789',
    'service' => 'Servicio de Prueba',
    'message' => 'Este es un mensaje de prueba',
    'submitted_at' => now()->format('Y-m-d H:i:s')
];

Mail::to('tucorreo@gmail.com')->send(new QuoteRequestMail($data));
```

---

## 🔍 Solución de Problemas

### Los emails no se envían

**1. Revisa los logs**
```bash
tail -f storage/logs/laravel.log
```

**2. Verifica la configuración**
```bash
php artisan config:show mail
```

**3. Limpia la cache**
```bash
php artisan config:clear
php artisan cache:clear
```

**4. Verifica las credenciales SMTP**
- Para Gmail: ¿Usaste contraseña de aplicación?
- ¿El puerto está correcto? (587 para TLS, 465 para SSL)
- ¿Las credenciales son correctas?

**5. Prueba la conexión SMTP**
```bash
telnet smtp.gmail.com 587
```

### Error 422 (Validación)

Verifica que los campos cumplan con:
- Nombre: mínimo 3 caracteres
- Email: formato válido con DNS
- Teléfono: mínimo 7 caracteres
- Mensaje: mínimo 10 caracteres

### Error 429 (Rate Limiting)

El usuario ha enviado demasiadas solicitudes.
- Por IP: 5 por hora
- Por email: 3 por hora

Solución: Esperar o limpiar el rate limit:
```bash
php artisan cache:clear
```

### Los emails van a SPAM

**Soluciones:**
1. Usa un dominio propio verificado
2. Configura registros SPF y DKIM
3. Usa un servicio como SendGrid
4. Evita palabras spam en el asunto

---

## 📊 Estructura de Datos

### Datos Enviados al Email del Admin

```php
[
    'name' => 'Juan Pérez',
    'email' => 'juan@example.com',
    'phone' => '+34 123 456 789',
    'service' => 'Desarrollo Web',
    'message' => 'Necesito una cotización para...',
    'ip_address' => '192.168.1.1',
    'user_agent' => 'Mozilla/5.0...',
    'submitted_at' => '2026-01-24 10:30:00'
]
```

---

## 🔐 Seguridad

### Implementado

✅ Rate limiting por IP y email
✅ Validación estricta de emails con DNS
✅ Sanitización de inputs
✅ CSRF protection
✅ Logging de IPs sospechosas
✅ Prevención de inyección SQL (Eloquent ORM)

### Recomendaciones Adicionales

1. **Honeypot**: Agregar campo oculto anti-bots
2. **reCAPTCHA**: Agregar Google reCAPTCHA v3
3. **Blacklist**: Crear lista de emails/IPs bloqueados
4. **SSL**: Usar HTTPS en producción

---

## 📈 Métricas y Monitoreo

### Logs Disponibles

Revisa `storage/logs/laravel.log`:

```
[2026-01-24 10:30:00] local.INFO: Cotización enviada exitosamente
{
    "name": "Juan Pérez",
    "email": "juan@example.com",
    "service": "Desarrollo Web",
    "ip": "192.168.1.1"
}
```

### Consultas SQL para Análisis

Si decides guardar en BD en el futuro:

```sql
-- Cotizaciones del mes
SELECT COUNT(*) FROM quote_requests
WHERE created_at >= DATE_SUB(NOW(), INTERVAL 1 MONTH);

-- Servicios más solicitados
SELECT service, COUNT(*) as total
FROM quote_requests
GROUP BY service
ORDER BY total DESC;
```

---

## 🚀 Mejoras Futuras (Opcional)

### 1. Guardar Cotizaciones en BD
- Crear modelo `QuoteRequest`
- Migración con tabla
- Panel admin para ver historial

### 2. Notificaciones en Tiempo Real
- WebSockets con Laravel Echo
- Notificación push al admin

### 3. Exportar Cotizaciones
- Exportar a CSV/Excel
- Generar reportes PDF

### 4. Dashboard de Estadísticas
- Gráficos de cotizaciones
- Métricas de conversión

---

## 📞 Soporte

Si encuentras algún problema:

1. Revisa los logs: `storage/logs/laravel.log`
2. Verifica la configuración de email
3. Asegúrate de tener conexión a internet
4. Revisa el firewall (puerto 587 o 465)

---

## ✅ Checklist de Implementación

- [ ] Configurar SMTP en `.env`
- [ ] Configurar email de destino en `company_infos`
- [ ] Ejecutar `php artisan config:clear`
- [ ] Ejecutar `php artisan cache:clear`
- [ ] Probar con Mailtrap primero
- [ ] Probar con email real
- [ ] Verificar que lleguen ambos emails (admin y cliente)
- [ ] Verificar logs
- [ ] Verificar en dispositivos móviles
- [ ] Configurar cron para colas (si usas queues)

---

## 📝 Notas Técnicas

### Colas de Email (Opcional)

Los emails están marcados con `ShouldQueue`, lo que significa que se enviarán en segundo plano si configuras las colas.

**Configurar colas:**

1. Cambia `QUEUE_CONNECTION` en `.env`:
```env
QUEUE_CONNECTION=database
```

2. Ejecuta las migraciones de cola:
```bash
php artisan queue:table
php artisan migrate
```

3. Ejecuta el worker:
```bash
php artisan queue:work
```

**Ventajas:**
- Respuesta inmediata al usuario
- Mejor rendimiento
- Reintentos automáticos si falla

---

## 📄 Licencia

Este módulo es parte del proyecto Laravel y sigue la misma licencia.

---

**Última actualización:** 24 de Enero 2026
**Versión:** 2.0
**Laravel:** 11.x
**Livewire:** 3.x
