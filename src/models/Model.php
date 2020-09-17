<?php

namespace models;

use PDO;

abstract class Model {
    protected $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    protected function redirectTo404() {
        header('Location: /pagenotfound');
        exit;
    }
}