<?php

namespace controllers;

use PDO;
use classes\ParamsHandler;

abstract class Controller
{
    protected $db;
    protected $paramshandler;

    //interface za view i ostale, kako bi pristupili svim view class
    public function __construct($db)
    {
        $this->db = $db;
        $this->paramshandler = new ParamsHandler();
    }

    protected function getParams() {
        return $this->paramshandler->retreiveData();
    }
}