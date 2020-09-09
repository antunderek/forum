<?php

namespace classes;

class Post {
    protected $topic;
    protected $user;
    protected $datePosted;
    protected $id;


    protected $content;

    public function __construct($topic, $user, $content, $id = null, $datePosted = null) {
        $this->topic = $topic;
        $this->user = $user;
        $this->datePosted = $datePosted;
        $this->id = $id;
        $this->content = $content;
    }

    public function getTopic()
    {
        return $this->topic;
    }

    public function setTopic($topic): void
    {
        $this->topic = $topic;
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

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
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