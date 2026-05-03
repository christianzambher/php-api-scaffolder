<?php
class TemplateService {
    public function render($templatePath, $variables = []) {
        $template = file_get_contents($templatePath);

        foreach ($variables as $key => $value) {
            $template = str_replace('{{' . $key . '}}', $value, $template);
        }

        return $template;
    }
}