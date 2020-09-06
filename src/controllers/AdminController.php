<?php

namespace controllers;

use classes\SessionWrapper;
use views\AdminView;
use models\ThreadModel;

class AdminController extends Controller {
    public function index() {
        if (!SessionWrapper::has('administrator')) {
            echo '404 controller goes here';
            die();
        }
        $threads = $this->getDataFromModel();
        $adminview = new AdminView();
        $adminview->renderPage('admin.php', $threads);
    }

    public function getDataFromModel() {
        $model = new ThreadModel($this->db);
        return $model->getAllData();
    }
}