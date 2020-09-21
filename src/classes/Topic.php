<?php

namespace classes;

class Topic extends ForumThread
{
    protected $topicCreator;
    protected $dateCreated;
    protected $topicId;

    public function __construct($name, $description, $topicCreator, $parent_thread, $topicId = null, $dateCreated = null)
    {
        parent::__construct($name, $description, $parent_thread);
        $this->topicCreator = $topicCreator;
        $this->topicId = $topicId;
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

    public function getTopicId()
    {
        return $this->topicId;
    }

    public function setTopicId($topicId): void
    {
        $this->topicId = $topicId;

    }
}