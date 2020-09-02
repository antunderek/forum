<?php

namespace controllers;

use PDO;
use classes\ParamsHandler;

abstract class Controller
{
    protected $paramshandler;
    protected $db;

    //interface za view i ostale, kako bi pristupili svim view class
    public function __construct(PDO $db)
    {
        $this->db = $db;
        $this->paramshandler = new ParamsHandler();
    }

    protected function getParams() {
        return $this->paramshandler->retreiveData();
    }
}