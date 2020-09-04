<?php

namespace controllers;

use classes\SessionWrapper;
use

class AdminController extends Controller {
    public function index() {
        $adminview = new AdminView();
        $adminview->renderPage('admin.php');
        if ($this->checkErrors()) {
            echo SessionWrapper::get('login_error');
            SessionWrapper::end('login_error');
        }
        SessionWrapper::end('temp_data');
    }
}