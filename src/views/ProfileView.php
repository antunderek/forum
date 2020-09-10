<?php

namespace views;

class ProfileView extends View {
    public function getUsername($data) {
        return $data[0]->getUsername();
    }

    public function getEmail($data) {
        return $data[0]->getEmail();
    }

    public function getImage($data) {
        return $data[0]->getImage();
    }
}