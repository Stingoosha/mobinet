<?php

namespace resources;
//
// Класс, отвечающий за сохранение данных URL-запросов
//
class Requester
{
    private static $instance = null;
    private $id; // id, передающийся в URL

    private function __construct() {}
    private function __sleep() {}
    private function __wakeup() {}
    private function __clone() {}

	/**
	 * singleton
	 */
    public static function getInstance()
    {
        if (empty(self::$instance)) {
            self::$instance = new Requester();
        }
        return self::$instance;
    }

	/**
	 * функция сохранения id
	 */
    public function setId(int $id)
    {
        $this->id = $id;
    }

	/**
	 * функция вывода id
	 */
    public function id()
    {
        return $this->id;
    }
}
