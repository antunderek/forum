<?php

namespace views;

use classes\User;

class HomeView extends View {
    public function renderPage() {
        echo $this->render('/var/www/html/forum/templates/home.php');
    }

    public function getPost() {
        return (isset($_POST['user'], $_POST['pass']) || !in_array('', $_POST)) ? new User(trim($_POST['user']), trim($_POST['pass'])) : null;
    }
}