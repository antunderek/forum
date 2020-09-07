<?php

namespace views;

class EditView extends View {
    public function getThreadName($data) {
        return isset($data[0]) ? $data[0]->getName() : "";
    }

    public function getThreadDescription($data) {
        return isset($data[0]) ? $data[0]->getDescription() : "";
    }

    public function isNewThread() {
        if ($_GET['thread'] === 'new') {
            return true;
        }
        return false;
    }

    public function getActionName() {
        if (!isset($_GET['action'])) {
            return 'update';
        }
        $actions = ['create' => 'create', 'delete' => 'delete'];
        return in_array($_GET['action'], $actions) ? $actions[$_GET['action']] : 'update';
    }
}