<?php

namespace views;

class TopiceditView extends View
{
    public function getTopicName($data)
    {
        return isset($data[0]) ? $data[0]->getName() : "";
    }

    public function getTopicDescription($data)
    {
        return isset($data[0]) ? $data[0]->getDescription() : "";
    }

    public function getTopicId($data)
    {
        return isset($data[0]) ? $data[0]->getId() : "";
    }

    public function getThreadName() {
        return $_GET['thread'];
    }

    public function isNewTopic()
    {
        if ($_GET['topic'] === 'newtopic') {
            return true;
        }
        return false;
    }

    public function getActionName()
    {
        if (!isset($_GET['action'])) {
            return 'update';
        }
        $actions = ['create' => 'create', 'delete' => 'delete'];
        return in_array($_GET['action'], $actions) ? $actions[$_GET['action']] : 'update';
    }
}