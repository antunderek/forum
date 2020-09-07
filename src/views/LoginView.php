<?php

namespace views;

use classes\SessionWrapper;
use MongoDB\Driver\Session;

class LoginView extends View {
    public function userLoggedIn() {
        return SessionWrapper::has('name');
    }

    public function checkLoginError() {
        if (SessionWrapper::has('login_error')) {
            return SessionWrapper::get('login_error');
        }
    }

    public function rememberedEmail() {
        if (SessionWrapper::has('temp_data')) {
            return SessionWrapper::get('temp_data', 'email');
        }
        return '';
    }
}
