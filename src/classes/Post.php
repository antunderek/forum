<?php

class Post {
    protected $topic;
    protected $user;
    protected $date_posted;
    protected $post;

    public function __construct($topic, $user, $date_posted, $post) {
        $this->topic = $topic;
        $this->user = $user;
        $this->date_posted = $date_posted;
        $this->post = $post;
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
        return $this->dateposted;
    }

    public function setDatePosted($dateposted): void
    {
        $this->dateposted = $dateposted;
    }

    public function getPost()
    {
        return $this->post;
    }

    public function setPost($post): void
    {
        $this->post = $post;
    }
}