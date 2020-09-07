<?php

namespace views;
use classes\SessionWrapper;

class SignupView extends View
{
    public function userLoggedIn() {
        return SessionWrapper::has('name');
    }

    public function checkRegisterError()
    {
        if (SessionWrapper::has('register_error')) {
            return SessionWrapper::get('register_error');
        }
    }

    public function rememberedUsername()
    {
        if (SessionWrapper::has('temp_data')) {
            return SessionWrapper::get('temp_data', 'username');
        }
        return '';
    }

    public function rememberedEmail()
    {
        if (SessionWrapper::has('temp_data')) {
            return SessionWrapper::get('temp_data', 'email');
        }
        return '';
    }
}