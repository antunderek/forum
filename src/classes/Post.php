<?php

class Post {
    protected $topicId;
    protected $id;
    protected $user;
    protected $datePosted;
    protected $content;

    public function __construct($topicId, $user, $datePosted, $content) {
        $this->topicId = $topicId;
        $this->user = $user;
        $this->datePosted = $datePosted;
        $this->content = $content;
    }

    public function getTopicId()
    {
        return $this->topicId;
    }

    public function setTopic($topicId): void
    {
        $this->topicId = $topicId;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user): void
    {
        $this->user = $user;
    }

    public function getDatePosted()
    {
        return $this->datePosted;
    }

    public function setDatePosted($datePosted): void
    {
        $this->datePosted = $datePosted;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content): void
    {
        $this->content = $content;
    }
}