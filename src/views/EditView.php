<?php

namespace views;

use classes\ParamsHandler;

class EditView extends View {
    public function getThreadName($data) {
        return isset($data[0]) ? $data[0]->getName() : "";
    }

    public function getThreadId($data) {
        return isset($data[0]) ? $data[0]->getId() : "";
    }

    public function getThreadDescription($data) {
        return isset($data[0]) ? $data[0]->getDescription() : "";
    }

    public function isNewThread() {
        if (ParamsHandler::get('thread') === 'newthread') {
            return true;
        }
        return false;
    }

    public function getActionName() {
        if (!ParamsHandler::has('action')) {
            return 'update';
        }
        $actions = ['create' => 'create', 'delete' => 'delete'];
        return in_array(ParamsHandler::get('action'), $actions) ? $actions[ParamsHandler::get('action')] : 'update';
    }
}