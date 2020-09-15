<?php

namespace models;

use PDO;

abstract class Model {
    protected $db;
    protected $purifier;

    public function __construct(PDO $db) {
        $this->db = $db;
    }
}