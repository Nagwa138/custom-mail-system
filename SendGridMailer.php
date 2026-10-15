<?php

class SendGridMailer
{
    private array $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function send(string $toEmail, string $toName, string $subject, string $htmlBody, array $inlineImages = []): bool
    {
        $payload = [
            'personalizations' => [['to' => [['email' => $toEmail, 'name' => $toName]]]],
            'from'             => ['email' => $this->config['from_email'], 'name' => $this->config['from_name']],
            'subject'          => $subject,
            'content'          => [['type' => 'text/html', 'value' => $htmlBody]],
        ];

        if (!empty($inlineImages)) {
            $payload['attachments'] = array_map(fn($img) => [
                'content'     => $img['data'],
                'type'        => $img['type'],
                'filename'    => $img['cid'] . '.png',
                'disposition' => 'inline',
                'content_id'  => $img['cid'],
            ], $inlineImages);
        }

        $ch = curl_init('https://api.sendgrid.com/v3/mail/send');
        curl_setopt_array($ch, [
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => json_encode($payload),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER     => [
                'Authorization: Bearer ' . $this->config['api_key'],
                'Content-Type: application/json',
            ],
        ]);

        $response  = curl_exec($ch);
        $httpCode  = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($curlError) {
            throw new RuntimeException("SendGrid request failed: {$curlError}");
        }

        if ($httpCode < 200 || $httpCode >= 300) {
            $body = json_decode($response, true);
            $msg  = $body['errors'][0]['message'] ?? $response;
            throw new RuntimeException("SendGrid API error ({$httpCode}): {$msg}");
        }

        return true;
    }
}
