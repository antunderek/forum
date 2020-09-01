<?php

namespace views;

class LoginView extends View {
    public function renderPage() {
        echo $this->render('/var/www/html/forum/templates/signin.php');
    }
}
