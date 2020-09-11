<?php

namespace controllers;

use views\PagenotfoundView;

class PagenotfoundController extends Controller {
    public function index()
    {
        $homeView = new PagenotfoundView();
        $homeView->renderPage('pageNotFound');
    }
}