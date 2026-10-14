<?php

class Logger
{
    private string $logFile;

    public function __construct(string $logDir)
    {
        if (!is_dir($logDir)) {
            mkdir($logDir, 0755, true);
        }
        $this->logFile = rtrim($logDir, '/') . '/mail.log';
    }

    public function log(
        string  $to,
        string  $template,
        string  $subject,
        string  $status,      // 'success' | 'failed'
        ?string $error = null,
        int     $durationMs = 0
    ): void {
        $entry = [
            'timestamp'   => date('c'),
            'to'          => $to,
            'template'    => $template,
            'subject'     => $subject,
            'status'      => $status,
            'duration_ms' => $durationMs,
        ];

        if ($error !== null) {
            $entry['error'] = $error;
        }

        file_put_contents(
            $this->logFile,
            json_encode($entry) . PHP_EOL,
            FILE_APPEND | LOCK_EX
        );
    }
}
