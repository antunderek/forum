<?php

namespace views;

abstract class View {
    private function render(string $template, array $data = []) {
        $template = BP . 'templates/' . $template . '.phtml';
        ob_start();
        extract($data, EXTR_SKIP);
        include $template;
        $output = ob_get_clean();
        return $output;
    }

    public function renderPage(string $template, array $data = [], array $headerData = ['title' => 'Title'], array $footerData = []) {
        echo $this->render('header', $headerData);
        echo $this->render($template, $data);
        echo $this->render('footer', $footerData);
    }
}