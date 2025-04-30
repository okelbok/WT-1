<?php

declare(strict_types=1);

class TemplateEngine {
    private function parseStatements(string $template): string
    {
        $statementsTemplates = [
            '/\{if (.+?)\}/' => '<?php if ($1): ?>',
            '/\{else\}/' => '<?php else: ?>',
            '/\{endif\}/' => '<?php endif; ?>',
            '/\{foreach (.+?) as (.+?)\}/' => '<?php foreach ($1 as $2): ?>',
            '/\{endforeach\}/' => '<?php endforeach; ?>',
        ];

        return preg_replace(array_keys($statementsTemplates), array_values($statementsTemplates), $template);
    }

    private function parseVariables(string $template): string {
        $variableTemplates = [
            '/\{\s*([a-zA-Z_][a-zA-Z0-9_\->\[\]\'"\(\)]*)\s*\}/' => '<?= htmlspecialchars($$1, ENT_QUOTES, "UTF-8") ?>',
            '/\{\s*([a-zA-Z_][a-zA-Z0-9_\.\[\]\'"\(\)]*)\s*\}/' => '<?= htmlspecialchars($$1, ENT_QUOTES, "UTF-8") ?>',
        ];

        return preg_replace(array_keys($variableTemplates), array_values($variableTemplates), $template);
    }

    private function executeCodeSamples(string $templateContent, array $data): string {
        extract($data);
        ob_start();

        eval('?>' . $templateContent);

        return ob_get_clean();
    }

    public function render(string $templatePath, array $data): string
    {
        $templateContent = file_get_contents($templatePath);

        $templateContent = $this->parseStatements($templateContent);
        $templateContent = $this->parseVariables($templateContent);

        return $this->executeCodeSamples($templateContent, $data);
    }
}