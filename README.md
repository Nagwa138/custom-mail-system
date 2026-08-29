# IMBox Mail Service

A lightweight, zero-dependency PHP mail microservice. Clients authenticate with a static API key and send branded emails by choosing a template — no SMTP credentials required on the client side.

---

## Features

- Static API key authentication
- SMTP sending via cPanel or Gmail (SSL & STARTTLS supported)
- HTML email templates with dynamic variables
- Clean JSON API — one endpoint, one POST request
- No Composer, no framework, no dependencies
- Config file excluded from version control

---

## Requirements

- PHP 8.0 or higher
- A web server with mod_rewrite enabled (Apache / cPanel)
- An SMTP email account (cPanel, Gmail, etc.)

---

## Project Structure

```
├── send.php                 # API entry point (POST)
├── Mailer.php               # Raw socket SMTP client
├── TemplateRenderer.php     # PHP-based template engine
├── config.php               # Credentials — NOT committed to git
├── config.example.php       # Safe template to copy from
├── .htaccess                # Security rules & routing
├── .gitignore
└── templates/
    ├── welcome.php
    ├── password_reset.php
    └── notification.php
```

---

## Installation

### 1. Clone the repository

```bash
git clone https://github.com/your-org/imbox-mail-service.git
cd imbox-mail-service
```

### 2. Create your config file

```bash
cp config.example.php config.php
```

Edit `config.php` with your SMTP credentials and API key:

```php
return [
    'api_key' => 'YOUR_STRONG_STATIC_KEY',

    'smtp' => [
        'host'       => 'imbox.solutions',
        'port'       => 465,
        'encryption' => 'ssl',
        'username'   => 'nagwa@imbox.solutions',
        'password'   => 'YOUR_PASSWORD',
        'from_email' => 'nagwa@imbox.solutions',
        'from_name'  => 'IMBox',
    ],
];
```

| Encryption | Port | Notes |
|---|---|---|
| `ssl` | 465 | Direct SSL — recommended for cPanel |
| `tls` | 587 | STARTTLS — used by Gmail |

### 3. Deploy to server

Upload all files to your subdomain's document root (e.g. `mail.imbox.solutions/`):

```
.htaccess
config.php          ← create this manually on the server, do NOT push to git
send.php
Mailer.php
TemplateRenderer.php
templates/
  welcome.php
  password_reset.php
  notification.php
```

> `config.php` is listed in `.gitignore`. Always create it directly on the server by copying `config.example.php`.

---

## API Reference

### Endpoint

```
POST https://mail.imbox.solutions/send.php
```

### Headers

| Header | Required | Description |
|---|---|---|
| `X-API-Key` | Yes | Static key defined in `config.php` |
| `Content-Type` | Yes | Must be `application/json` |

### Request Body

| Field | Type | Required | Description |
|---|---|---|---|
| `template` | string | Yes | Name of the template to use |
| `receiver_email` | string | Yes | Recipient email address |
| `receiver_name` | string | Yes | Recipient display name |
| `subject` | string | No | Email subject (falls back to template default) |
| `variables` | object | No | Extra variables passed into the template |

### Response

```json
{
  "status": 200,
  "message": "Email sent successfully.",
  "to": "john@example.com",
  "template": "welcome"
}
```

### Error responses

| Status | Meaning |
|---|---|
| 401 | Missing or invalid `X-API-Key` |
| 404 | Template not found |
| 405 | Wrong HTTP method (must be POST) |
| 422 | Missing or invalid field |
| 500 | SMTP connection or sending failure |

---

## Templates

### `welcome`

Sent when a new user registers.

```json
{
  "template": "welcome",
  "receiver_email": "john@example.com",
  "receiver_name": "John Doe"
}
```

---

### `password_reset`

Sent when a user requests a password reset. Accepts an optional `reset_link` variable.

```json
{
  "template": "password_reset",
  "receiver_email": "john@example.com",
  "receiver_name": "John Doe",
  "variables": {
    "reset_link": "https://app.imbox.solutions/reset/abc123"
  }
}
```

---

### `notification`

General-purpose notification. Accepts a `message` variable.

```json
{
  "template": "notification",
  "receiver_email": "john@example.com",
  "receiver_name": "John Doe",
  "subject": "Your order has shipped",
  "variables": {
    "message": "Your order #1042 has been dispatched and is on its way."
  }
}
```

---

## Adding a New Template

1. Create a new file in `templates/`, e.g. `templates/invoice.php`
2. Use `$receiver_name` and any variables passed via the `variables` field
3. That's it — the template is immediately available via the API

```php
// templates/invoice.php
<p>Hello, <?= htmlspecialchars($receiver_name) ?></p>
<p>Your invoice total is: <?= htmlspecialchars($amount) ?></p>
```

Call it with:

```json
{
  "template": "invoice",
  "receiver_email": "client@example.com",
  "receiver_name": "Client Name",
  "variables": { "amount": "$149.00" }
}
```

---

## Security

- API key comparison uses `hash_equals()` to prevent timing attacks
- Template names are sanitized with a regex whitelist — no path traversal possible
- `config.php`, `Mailer.php`, and `TemplateRenderer.php` are blocked from direct browser access via `.htaccess`
- Directory listing is disabled
- `config.php` is excluded from git via `.gitignore`

---

## Local Development

Requires PHP 8+ CLI.

```bash
php -S 127.0.0.1:8765 -t .
```

```bash
curl -X POST http://127.0.0.1:8765/send.php \
  -H "X-API-Key: YOUR_KEY" \
  -H "Content-Type: application/json" \
  -d '{"template":"welcome","receiver_email":"test@example.com","receiver_name":"Test User"}'
```

---

## License

MIT © IMBox
