<?php

namespace controllers;

use classes\SessionWrapper;

class LogoutController extends Controller {
    public function index() {
        $this->logout();
    }

    public function logout() {
        SessionWrapper::destroy();
        header('Location: /');
    }
}