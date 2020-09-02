<?php

namespace controllers;

use views\HomeView;

class HomeController extends Controller
{
    public function index()
    {
        $homeview = new HomeView();
        $homeview->renderPage('home.php');
    }
}