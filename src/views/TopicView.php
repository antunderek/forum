<?php

namespace views;

use classes\ParamsHandler;
use classes\Topic;

class TopicView extends View {
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
        return isset($data[0]) ? $data[0]->getTopicId() : "";
    }

    public function getThreadName() {
        return ParamsHandler::get('thread');
    }

    public function isNewTopic()
    {
        if (ParamsHandler::get('topic') === 'newtopic') {
            return true;
        }
        return false;
    }

    public function getActionName()
    {
        if (!ParamsHandler::has('action')) {
            return 'update';
        }
        $actions = ['create' => 'create', 'delete' => 'delete'];
        return in_array(ParamsHandler::get('action'), $actions) ? $actions[ParamsHandler::get('action')] : 'update';
    }
}