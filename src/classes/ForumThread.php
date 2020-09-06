<?php

namespace classes;

class ForumThread {
    protected $name;
    protected $description;
    protected $parent;

    public function __construct($name, $description, $parent = null) {
        $this->name = $name;
        $this->description = $description;
        $this->parent = $parent;
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

    public function getParent()
    {
        return $this->parent;
    }

    public function setParent($parent): void
    {
        $this->parent = $parent;
    }
}