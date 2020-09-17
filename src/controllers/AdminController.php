<?php

namespace controllers;

use classes\SessionWrapper;
use models\UserModel;
use models\ThreadModel;
use views\AdminView;

class AdminController extends Controller {
    public function index() {
        if (!SessionWrapper::has('administrator')) {
            $this->redirectTo404();
        }
        $threads = $this->getDataFromModel();
        $users = $this->getUsers();
        $data = ['threads' => $threads, 'users' => $users];
        $adminview = new AdminView();
        $adminview->renderPage('admin', $data);
    }

    private function getDataFromModel() {
        $model = new ThreadModel($this->db);
        return $model->getAllThreads();
    }

    private function getUsers() {
        $model = new UserModel($this->db);
        return $model->getUsers();
    }
}