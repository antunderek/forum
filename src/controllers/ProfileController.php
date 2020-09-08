<?php

namespace controllers;

use views\ProfileView;
use models\UserModel;
use classes\SessionWrapper;

class ProfileController extends Controller
{
    public function index()
    {
        $adminview = new ProfileView();
        $adminview->renderPage('profile.php', );
    }

    public function getDataFromModel()
    {
        $model = new UserModel($this->db);
        return $model->getUser();
    }
}