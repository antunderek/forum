<?php

namespace classes;

class Topic extends ForumThread {
    protected $topicCreator;
    protected $dateCreated;

    public function __construct($name, $description, $topicCreator, $dateCreated) {
        parent::__construct($name, $description);
        $this->topicCreator = $topicCreator;
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
}