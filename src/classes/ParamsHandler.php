<?php

namespace classes;

class ParamsHandler {

    private function typeMethod() {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            return $_GET;
        }
        elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            return $_POST;
        }
        return null;
    }

    public function retreiveData() {
        return $this->typeMethod();
    }
}