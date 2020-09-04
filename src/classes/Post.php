<?php

class Post {
    protected $topic;
    protected $user;
    protected $dateposted;
    protected $post;

    public function __construct($topic, $user, $dateposted, $post) {
        $this->topic = $topic;
        $this->user = $user;
        $this->dateposted = $dateposted;
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

    public function getDateposted()
    {
        return $this->dateposted;
    }

    public function setDateposted($dateposted): void
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