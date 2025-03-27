<?php

class templateEngine
{
    private function parseTemplate(string $template, array $data): string
    {
        foreach ($data as $key => $value) {
            $template = str_replace('{' . $key . '}', $value, $template);
        }

        return $template;
    }

    public function render(string $templatePath, array $data): string
    {
        $templateContent = file_get_contents($templatePath);

        $templateData = [
            // TODO: rewrite template engine to work with regular expressions
        ];

        $templateContent = $this->parseTemplate($templateContent, $templateData);

        extract($data);

        ob_start();
        eval('?>' . $templateContent);
        return ob_get_clean();
    }
}