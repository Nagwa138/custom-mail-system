# IMBox Mail Service — Backend Integration Guide

## Overview

Instead of configuring SMTP directly in your application, use the IMBox Mail Service API to send emails. You only need to make a single HTTP POST request with your API key — no SMTP setup, no email credentials in your app.

---

## Endpoint

```
POST https://mail.imbox.solutions/send.php
```

---

## Authentication

Every request must include the API key in the header:

```
X-API-Key: YOUR_API_KEY
```

---

## Request

**Headers**

```
Content-Type: application/json
X-API-Key: YOUR_API_KEY
```

**Body**

```json
{
  "template":       "welcome",
  "receiver_email": "user@example.com",
  "receiver_name":  "John Doe",
  "subject":        "Optional custom subject",
  "variables":      {}
}
```

| Field | Type | Required | Description |
|---|---|---|---|
| `template` | string | Conditional | Name of the built-in template to use. Required unless `html_body` is provided. |
| `html_body` | string | Conditional | Raw HTML of your own template. When provided, `template` is ignored. |
| `receiver_email` | string | Yes | Recipient email address |
| `receiver_name` | string | Yes | Recipient display name |
| `subject` | string | No | Custom subject line — falls back to template default if omitted |
| `variables` | object | No | Extra dynamic values injected into built-in templates (not used with `html_body`) |

---

## Available Templates

### `welcome`
Sent when a new user registers.

```json
{
  "template":       "welcome",
  "receiver_email": "user@example.com",
  "receiver_name":  "John Doe"
}
```

---

### `password_reset`
Sent when a user requests a password reset. Pass the reset link via `variables`.

```json
{
  "template":       "password_reset",
  "receiver_email": "user@example.com",
  "receiver_name":  "John Doe",
  "variables": {
    "reset_link": "https://yourapp.com/reset/TOKEN_HERE"
  }
}
```

---

### `notification`
General-purpose notification. Pass the message body via `variables`.

```json
{
  "template":       "notification",
  "receiver_email": "user@example.com",
  "receiver_name":  "John Doe",
  "subject":        "Your order has shipped",
  "variables": {
    "message": "Your order #1042 has been dispatched."
  }
}
```

---

### `otp`
Sends a One-Time Password (OTP) / verification code. Pass the code via `variables`. Optionally set `expires_in` — defaults to `10 minutes`.

```json
{
  "template":       "otp",
  "receiver_email": "user@example.com",
  "receiver_name":  "John Doe",
  "variables": {
    "code":       "482910",
    "expires_in": "10 minutes"
  }
}
```

---

### Custom HTML Template
Send your own HTML instead of using a built-in template. Pass the full HTML string in `html_body` and omit `template`.

```json
{
  "html_body":      "<html><body><h1>Hello, John!</h1><p>Your custom email.</p></body></html>",
  "receiver_email": "user@example.com",
  "receiver_name":  "John Doe",
  "subject":        "Custom Email Subject"
}
```

> You are responsible for building the full HTML. The service sends it as-is — no variable injection is performed on custom HTML.

---

## Responses

**Success**
```json
{
  "status":   200,
  "message":  "Email sent successfully.",
  "to":       "user@example.com",
  "template": "welcome"
}
```

**Error**
```json
{
  "status":  422,
  "message": "Missing required field: receiver_email"
}
```

| Status | Meaning |
|---|---|
| 200 | Email sent successfully |
| 401 | Invalid or missing API key |
| 404 | Template not found |
| 405 | Wrong HTTP method — must be POST |
| 422 | Missing or invalid field |
| 500 | Mail server error |

---

## Code Examples

### PHP
```php
function sendMail(string $template, string $email, string $name, array $variables = []): array
{
    $response = file_get_contents('https://mail.imbox.solutions/send.php', false,
        stream_context_create([
            'http' => [
                'method'  => 'POST',
                'header'  => "Content-Type: application/json\r\nX-API-Key: YOUR_API_KEY",
                'content' => json_encode([
                    'template'       => $template,
                    'receiver_email' => $email,
                    'receiver_name'  => $name,
                    'variables'      => $variables,
                ]),
            ],
        ])
    );
    return json_decode($response, true);
}

// Usage
sendMail('welcome', 'user@example.com', 'John Doe');
sendMail('password_reset', 'user@example.com', 'John Doe', ['reset_link' => 'https://yourapp.com/reset/abc123']);
sendMail('otp', 'user@example.com', 'John Doe', ['code' => '482910', 'expires_in' => '10 minutes']);

// Custom HTML template
function sendCustomMail(string $html, string $subject, string $email, string $name): array
{
    $response = file_get_contents('https://mail.imbox.solutions/send.php', false,
        stream_context_create([
            'http' => [
                'method'  => 'POST',
                'header'  => "Content-Type: application/json\r\nX-API-Key: YOUR_API_KEY",
                'content' => json_encode([
                    'html_body'      => $html,
                    'subject'        => $subject,
                    'receiver_email' => $email,
                    'receiver_name'  => $name,
                ]),
            ],
        ])
    );
    return json_decode($response, true);
}
```

---

### JavaScript (fetch)
```js
async function sendMail(template, email, name, variables = {}) {
  const res = await fetch('https://mail.imbox.solutions/send.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-API-Key': 'YOUR_API_KEY',
    },
    body: JSON.stringify({ template, receiver_email: email, receiver_name: name, variables }),
  });
  return res.json();
}

// Usage
await sendMail('welcome', 'user@example.com', 'John Doe');
await sendMail('password_reset', 'user@example.com', 'John Doe', { reset_link: 'https://yourapp.com/reset/abc123' });
await sendMail('otp', 'user@example.com', 'John Doe', { code: '482910', expires_in: '10 minutes' });

// Custom HTML template
async function sendCustomMail(html, subject, email, name) {
  const res = await fetch('https://mail.imbox.solutions/send.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json', 'X-API-Key': 'YOUR_API_KEY' },
    body: JSON.stringify({ html_body: html, subject, receiver_email: email, receiver_name: name }),
  });
  return res.json();
}
```

---

### Python
```python
import requests

MAIL_API = 'https://mail.imbox.solutions/send.php'
MAIL_KEY  = 'YOUR_API_KEY'

def send_mail(template, email, name, variables=None):
    response = requests.post(MAIL_API, json={
        'template':       template,
        'receiver_email': email,
        'receiver_name':  name,
        'variables':      variables or {},
    }, headers={'X-API-Key': MAIL_KEY})
    return response.json()

# Usage
send_mail('welcome', 'user@example.com', 'John Doe')
send_mail('password_reset', 'user@example.com', 'John Doe', {'reset_link': 'https://yourapp.com/reset/abc123'})
send_mail('otp', 'user@example.com', 'John Doe', {'code': '482910', 'expires_in': '10 minutes'})

# Custom HTML template
def send_custom_mail(html, subject, email, name):
    response = requests.post(MAIL_API, json={
        'html_body':      html,
        'subject':        subject,
        'receiver_email': email,
        'receiver_name':  name,
    }, headers={'X-API-Key': MAIL_KEY})
    return response.json()
```

---

### cURL
```bash
curl -X POST https://mail.imbox.solutions/send.php \
  -H "X-API-Key: YOUR_API_KEY" \
  -H "Content-Type: application/json" \
  -d '{
    "template":       "welcome",
    "receiver_email": "user@example.com",
    "receiver_name":  "John Doe"
  }'
```

---

## Notes for the Developer

- **Never configure SMTP in your app** — all mail goes through this service
- **Store the API key in your `.env`** — never hardcode it in source files
- **The API key is shared** — do not expose it publicly or commit it to git
- **New templates** are added on the mail service side — contact the IMBox team if you need a new template
- **All requests must be POST** — GET requests will return 405
