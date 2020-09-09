<?php

namespace views;

class PostView extends View {
    public function getContent($data) {
        return $data[0]->getContent();
    }

    public function getUser($data) {
        return $data[0]->getUser();
    }

    public function getId($data) {
        return $data[0]->getId();
    }

    public function getTopic($data) {
        return $data[0]->getTopic();
    }
}