<?php

namespace controllers;
use PDO;

use classes\SessionWrapper;
use classes\ParamsHandler;
use models\UserModel;


abstract class Controller
{
    protected $paramshandler;
    protected $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
        $this->paramshandler = new ParamsHandler();
        $this->checkUserSession();
    }

    protected function getParams() {
        return $this->paramshandler->retreiveData();
    }

    protected function redirect($url) {
        header("Location: {$url}");
        exit;
    }

    protected function redirectTo404() {
        header('Location: /pagenotfound');
        exit;
    }

    protected function checkUserSession() {
        if (!SessionWrapper::has('id')) {
            return;
        }
        $model = new UserModel($this->db);
        $model->doSessionCheck();
    }

    protected function checkIfAdmin() {
        if (!SessionWrapper::has('administrator')) {
            $this->redirectTo404();
        }
        return true;
    }
}