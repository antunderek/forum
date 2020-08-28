<?php

class HomeView extends View {
    public function __construct() {
        //$this->renderPage();
    }

    public function renderPage() {
        //require_once('/var/www/html/forum/app/Views/html/home.php');
        echo $this->render('/var/www/html/forum/app/Views/html/home.php');
    }

    public function getPost() {
        return isset($_POST['user'], $_POST['pass']) ? new User($_POST['user'], $_POST['pass']) : null;
        /*$name = $_POST['user'];
        $pass = $_POST['pass'];
        if (isset($name, $pass)) {
            return new User($name, $pass);
        }
        return [
            'user' => $_POST['user'],
            'pass' => $_POST['pass'],
        ];*/
    }
}