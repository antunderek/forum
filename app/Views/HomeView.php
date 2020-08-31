<?php

class HomeView extends View {
    public function __construct() {
        //$this->renderPage();
    }

    public function renderPage() {
        echo $this->render('/var/www/html/forum/app/Views/html/home.php');
    }

    public function getPost() {
        return isset($_POST['user'], $_POST['pass']) ? new User($_POST['user'], $_POST['pass']) : null;

    }
}