<?php

namespace views;

use classes\ForumThread;

class HomeView extends View {
    protected $data;

    public function setData($data) {
        $this->data = $data;
    }

    public function getData() {
        return $this->data;
    }
}