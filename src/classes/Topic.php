<?php

namespace classes;

class Topic extends ForumThread
{
    protected $topicCreator;
    protected $dateCreated;
    protected $id;

    public function __construct($name, $description, $topicCreator, $parent_thread, $id = null, $dateCreated = null)
    {
        parent::__construct($name, $description, $parent_thread);
        $this->topicCreator = $topicCreator;
        $this->id = $id;
        $this->dateCreated = $dateCreated;
    }

    public function getTopicCreator()
    {
        return $this->topicCreator;
    }

    public function setTopicCreator($topicCreator): void
    {
        $this->topicCreator = $topicCreator;
    }

    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    public function setDateCreated($dateCreated): void
    {
        $this->dateCreated = $dateCreated;
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