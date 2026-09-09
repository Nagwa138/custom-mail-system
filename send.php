<?php
/**
 * IMBox Mail Service — API Entry Point
 *
 * POST /send.php
 * Header: X-API-Key: <static key>
 * Body (JSON):
 *   {
 *     "template"       : "welcome",                // required unless html_body is provided
 *     "html_body"      : "<html>...</html>",       // optional — custom HTML overrides template
 *     "receiver_email" : "john@example.com",
 *     "receiver_name"  : "John Doe",
 *     "subject"        : "Welcome to IMBox",       // optional — falls back to template default
 *     "variables"      : { ... }                   // optional extra template variables (used with template only)
 *   }
 */

header('Content-Type: application/json');

require_once __DIR__ . '/Mailer.php';
require_once __DIR__ . '/TemplateRenderer.php';

$config = require __DIR__ . '/config.php';

// ── helpers ──────────────────────────────────────────────────────────────────

function respond(int $status, string $message, array $extra = []): never
{
    http_response_code($status);
    echo json_encode(array_merge(['status' => $status, 'message' => $message], $extra));
    exit;
}

// ── method guard ─────────────────────────────────────────────────────────────

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    respond(405, 'Method Not Allowed. Use POST.');
}

// ── API key authentication ────────────────────────────────────────────────────

$providedKey = $_SERVER['HTTP_X_API_KEY'] ?? '';
if (!hash_equals($config['api_key'], $providedKey)) {
    respond(401, 'Unauthorized. Invalid or missing X-API-Key header.');
}

// ── parse body ────────────────────────────────────────────────────────────────

$body = json_decode(file_get_contents('php://input'), true);
if (!is_array($body)) {
    respond(400, 'Invalid JSON body.');
}

$template      = trim($body['template']       ?? '');
$customHtml    = $body['html_body']           ?? null;
$receiverEmail = trim($body['receiver_email'] ?? '');
$receiverName  = trim($body['receiver_name']  ?? '');
$subject       = trim($body['subject']        ?? '');
$extraVars     = is_array($body['variables']  ?? null) ? $body['variables'] : [];

// ── validation ────────────────────────────────────────────────────────────────

if ($template === '' && $customHtml === null) {
    respond(422, 'Missing required field: template or html_body (one must be provided)');
}
if ($receiverEmail === '') {
    respond(422, 'Missing required field: receiver_email');
}
if (!filter_var($receiverEmail, FILTER_VALIDATE_EMAIL)) {
    respond(422, 'Invalid receiver_email address.');
}
if ($receiverName === '') {
    respond(422, 'Missing required field: receiver_name');
}
if ($customHtml !== null && !is_string($customHtml)) {
    respond(422, 'Invalid html_body: must be a string.');
}

// ── default subjects per template ─────────────────────────────────────────────

$defaultSubjects = [
    'welcome'        => 'Welcome to IMBox!',
    'password_reset' => 'Password Reset Request',
    'notification'   => 'You have a new notification',
];

if ($subject === '') {
    $subject = $defaultSubjects[$template] ?? ucfirst(str_replace('_', ' ', $template));
}

// ── render template ───────────────────────────────────────────────────────────

$inlineImages = [];

if ($customHtml !== null) {
    // integrator-supplied HTML — use as-is
    $htmlBody = $customHtml;
    $usedTemplate = 'custom';
} else {
    $renderer = new TemplateRenderer(__DIR__ . '/templates');

    if (!empty($extraVars['qr_code'])) {
        $inlineImages[] = ['cid' => 'qr_code', 'data' => $extraVars['qr_code'], 'type' => 'image/png'];
        $extraVars['qr_code'] = true; // keep truthy so the template renders the <img> tag
    }

    try {
        $variables = array_merge($extraVars, [
            'receiver_name'  => $receiverName,
            'receiver_email' => $receiverEmail,
        ]);
        $htmlBody = $renderer->render($template, $variables);
    } catch (InvalidArgumentException $e) {
        respond(404, $e->getMessage(), [
            'available_templates' => $renderer->available(),
        ]);
    }

    $usedTemplate = $template;
}

// ── send mail ─────────────────────────────────────────────────────────────────

try {
    $mailer = new Mailer($config['smtp']);
    $mailer->send($receiverEmail, $receiverName, $subject, $htmlBody, $inlineImages);
    respond(200, 'Email sent successfully.', [
        'to'       => $receiverEmail,
        'template' => $usedTemplate,
    ]);
} catch (RuntimeException $e) {
    respond(500, 'Failed to send email: ' . $e->getMessage());
}
