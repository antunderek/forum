<?php

class HomeController {
    protected $homeview;

    public function index() {
        $homeview = new HomeView;
        $homeview->renderPage();
    }

    public function passValue($value) {
        return $value;
    }
}