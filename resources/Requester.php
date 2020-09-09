<?php

namespace resources;

class Requester
{
    public static $instance = null;
    public $id;

    private function __construct() {}
    private function __sleep() {}
    private function __wakeup() {}
    private function __clone() {}

    public static function getInstance()
    {
        if (empty(self::$instance)) {
            self::$instance = new Requester();
        }
        return self::$instance;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function id()
    {
        return $this->id;
    }
}
