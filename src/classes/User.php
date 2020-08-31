<?php

namespace classes;

class User {
    protected $user;
    protected $password;
    protected $email;
    protected $administrator;

    public function __construct($user, $password, $email) {
        $this->user = $user;
        $this->password = $password;
        $this->email = $email;
        //$this->administrator = $administrator;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user): void
    {
        $this->user = $user;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password): void
    {
        $this->password = $password;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email): void
    {
        $this->email = $email;
    }

    public function getAdministrator()
    {
        return $this->administrator;
    }

    public function setAdministrator($administrator): void
    {
        $this->administrator = $administrator;
    }
}