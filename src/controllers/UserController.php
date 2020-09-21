<?php

namespace controllers;

use classes\ParamsHandler;
use classes\SessionWrapper;
use models\UserModel;
use views\UserView;

class UserController extends Controller {
    public function index() {
        $model = new UserModel($this->db);
        $userview = new UserView();
        if (ParamsHandler::has('id')) {
            $user[] = $model->getUserById(ParamsHandler::get('id'));
        } else {
            $user[] = $model->getUserById(SessionWrapper::get('id'));
        }
        if (!$user[0]) {
            $this->redirectTo404();
        }
        $userview->renderPage('user', $user);
    }
}