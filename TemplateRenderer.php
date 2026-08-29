<?php

class TemplateRenderer
{
    private string $templateDir;

    public function __construct(string $templateDir)
    {
        $this->templateDir = rtrim($templateDir, DIRECTORY_SEPARATOR);
    }

    public function render(string $templateName, array $variables): string
    {
        $templateName = preg_replace('/[^a-z0-9_\-]/i', '', $templateName);
        $path = $this->templateDir . DIRECTORY_SEPARATOR . $templateName . '.php';

        if (!file_exists($path)) {
            throw new InvalidArgumentException("Template not found: {$templateName}");
        }

        extract($variables, EXTR_SKIP);

        ob_start();
        include $path;
        return ob_get_clean();
    }

    public function available(): array
    {
        $files = glob($this->templateDir . DIRECTORY_SEPARATOR . '*.php');
        return array_map(fn($f) => basename($f, '.php'), $files);
    }
}
