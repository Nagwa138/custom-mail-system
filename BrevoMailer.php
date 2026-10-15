<?php

class BrevoMailer
{
    private array $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function send(string $toEmail, string $toName, string $subject, string $htmlBody, array $inlineImages = []): bool
    {
        $payload = [
            'sender'      => ['name' => $this->config['from_name'], 'email' => $this->config['from_email']],
            'to'          => [['email' => $toEmail, 'name' => $toName]],
            'subject'     => $subject,
            'htmlContent' => $htmlBody,
            'textContent' => wordwrap(strip_tags(preg_replace('/<br\s*\/?>/i', "\n", $htmlBody)), 76, "\n"),
        ];

        if (!empty($inlineImages)) {
            $payload['attachment'] = array_map(fn($img) => [
                'name'      => $img['cid'] . '.png',
                'content'   => $img['data'],
                'contentId' => $img['cid'],
            ], $inlineImages);
        }

        $ch = curl_init('https://api.brevo.com/v3/smtp/email');
        curl_setopt_array($ch, [
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => json_encode($payload),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER     => [
                'api-key: ' . $this->config['api_key'],
                'Content-Type: application/json',
                'Accept: application/json',
            ],
        ]);

        $response  = curl_exec($ch);
        $httpCode  = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($curlError) {
            throw new RuntimeException("Brevo request failed: {$curlError}");
        }

        if ($httpCode < 200 || $httpCode >= 300) {
            $body = json_decode($response, true);
            $msg  = $body['message'] ?? $response;
            throw new RuntimeException("Brevo API error ({$httpCode}): {$msg}");
        }

        return true;
    }
}
