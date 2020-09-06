<?php

namespace views;

use classes\SessionWrapper;

abstract class View {
    private function render(string $template, array $data = []) {
        $template = BP . 'templates/' . $template;
        ob_start();
        extract($data, EXTR_SKIP);
        include $template;
        $output = ob_get_clean();
        return $output;
    }

    public function renderPage(string $template, array $data = []) {
        echo $this->render($template, $data);
    }
}