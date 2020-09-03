<?php

namespace classes;

class ForumThread {
    protected $name;
    protected $description;

    public function __construct($name, $description) {
        $this->name = $name;
        $this->description = $description;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name): void
    {
        $this->name = $name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description): void
    {
        $this->description = $description;
    }

}