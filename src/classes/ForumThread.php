<?php

namespace classes;

class ForumThread {
    protected $name;
    protected $description;
    protected $id;

    public function __construct($name, $description, $id = null) {
        $this->name = $name;
        $this->description = $description;
        $this->id = $id;
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

    public function getId()
    {
        return $this->id;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }
}