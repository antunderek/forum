<?php

namespace controllers;

use classes\SessionWrapper;
use models\UserModel;
use views\AdminView;
use models\ThreadModel;

class AdminController extends Controller {
    public function index() {
        if (!SessionWrapper::has('administrator')) {
            echo '404 controller goes here';
            die();
        }
        $threads = $this->getDataFromModel();
        $users = $this->getUsers();
        $data = ['threads' => $threads, 'users' => $users];
        $adminview = new AdminView();
        $adminview->renderPage('admin.php', $data);
    }

    public function getDataFromModel() {
        $model = new ThreadModel($this->db);
        return $model->getAllThreads();
    }

    public function getUsers() {
        $model = new UserModel($this->db);
        return $model->getUsers();
    }
}