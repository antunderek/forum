<?php

class HomeView {
    public function __construct() {
        $this->renderPage();
    }

    public function renderPage() {
        require_once('/var/www/html/forum/app/Views/html/home.php');
    }
    public function getPost() {
        $name = $_POST['user'];
        $pass = $_POST['pass'];
        $user = new User($name, $pass);
        /*return [
            'user' => $_POST['user'],
            'pass' => $_POST['pass'],
        ];*/
        return $user;
    }
}