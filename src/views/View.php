<?php

namespace views;

abstract class View {
    public function render(string $template) {
        ob_start();
        //extract($data, EXTR_SKIP);
        include $template;
        $output = ob_get_clean();
        return $output;
    }
}