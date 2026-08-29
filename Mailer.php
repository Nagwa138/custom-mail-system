<?php

class Mailer
{
    private array $smtp;

    public function __construct(array $smtp)
    {
        $this->smtp = $smtp;
    }

    public function send(string $toEmail, string $toName, string $subject, string $htmlBody): bool
    {
        $socket    = $this->connect();
        $fromEmail = $this->smtp['from_email'];
        $fromName  = $this->smtp['from_name'];

        $this->ehlo($socket);

        // Port 587 (TLS): upgrade plain connection with STARTTLS then re-EHLO
        // Port 465 (SSL): already encrypted at connect, skip STARTTLS
        if (strtolower($this->smtp['encryption']) === 'tls') {
            $this->startTls($socket);
            $this->ehlo($socket);
        }

        $this->authenticate($socket);

        $this->cmd($socket, "MAIL FROM:<{$fromEmail}>", 250);
        $this->cmd($socket, "RCPT TO:<{$toEmail}>",    250);
        $this->cmd($socket, "DATA",                     354);

        $headers  = "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
        $headers .= "From: =?UTF-8?B?" . base64_encode($fromName) . "?= <{$fromEmail}>\r\n";
        $headers .= "To: =?UTF-8?B?" . base64_encode($toName) . "?= <{$toEmail}>\r\n";
        $headers .= "Subject: =?UTF-8?B?" . base64_encode($subject) . "?=\r\n";
        $headers .= "Date: " . date('r') . "\r\n";

        fwrite($socket, $headers . "\r\n" . $htmlBody . "\r\n.\r\n");
        $response = $this->read($socket);
        if (substr($response, 0, 3) !== '250') {
            throw new RuntimeException("DATA rejected: {$response}");
        }

        $this->cmd($socket, "QUIT", 221);
        fclose($socket);

        return true;
    }

    private function connect()
    {
        $context = stream_context_create([
            'ssl' => [
                'verify_peer'      => true,
                'verify_peer_name' => true,
            ],
        ]);

        // SSL (465): connect directly over ssl://
        // TLS (587): connect plain over tcp://, then upgrade via STARTTLS
        $encryption = strtolower($this->smtp['encryption']);
        $scheme     = $encryption === 'ssl' ? 'ssl' : 'tcp';

        $socket = stream_socket_client(
            "{$scheme}://{$this->smtp['host']}:{$this->smtp['port']}",
            $errno, $errstr, 10, STREAM_CLIENT_CONNECT, $context
        );

        if (!$socket) {
            throw new RuntimeException("SMTP connect failed: {$errstr} ({$errno})");
        }

        stream_set_timeout($socket, 10);

        $greeting = $this->read($socket);
        if (substr($greeting, 0, 3) !== '220') {
            throw new RuntimeException("Unexpected SMTP greeting: {$greeting}");
        }

        return $socket;
    }

    private function ehlo($socket): void
    {
        $this->cmd($socket, "EHLO " . gethostname(), 250);
    }

    private function startTls($socket): void
    {
        $this->cmd($socket, "STARTTLS", 220);
        if (!stream_socket_enable_crypto($socket, true, STREAM_CRYPTO_METHOD_TLS_CLIENT)) {
            throw new RuntimeException("Failed to enable TLS");
        }
    }

    private function authenticate($socket): void
    {
        $this->cmd($socket, "AUTH LOGIN", 334);
        $this->cmd($socket, base64_encode($this->smtp['username']), 334);
        $this->cmd($socket, base64_encode($this->smtp['password']), 235);
    }

    private function cmd($socket, string $command, int $expectedCode): string
    {
        fwrite($socket, $command . "\r\n");
        $response = $this->read($socket);
        if (substr($response, 0, 3) !== (string)$expectedCode) {
            throw new RuntimeException("CMD '{$command}' expected {$expectedCode}, got: {$response}");
        }
        return $response;
    }

    private function read($socket): string
    {
        $response = '';
        while ($line = fgets($socket, 512)) {
            $response .= $line;
            if (strlen($line) >= 4 && $line[3] === ' ') break;
        }
        return trim($response);
    }
}
