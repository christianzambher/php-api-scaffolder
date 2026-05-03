<?php
class TemplateService {
        
    /**
     * Renders a template file by replacing placeholders with provided variables.
     * @param  string $templatePath Path of the template file
     * @param  array $variables Associative array of variables to replace in the template
     * @return string Rendered template content
     */
    public function render($templatePath, $variables = []) {
        $template = file_get_contents($templatePath);

        foreach ($variables as $key => $value) {
            $template = str_replace('{{' . $key . '}}', $value, $template);
        }

        return $template;
    }
}