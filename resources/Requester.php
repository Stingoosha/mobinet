<?php
namespace resources;

/**
 * Класс, отвечающий за сохранение данных URL-запросов
 */
class Requester
{
    /**
     * @var int $id id, составляющая URL (например, '/phones/{id}')
     */
    private static $id;

	/**
	 * Функция сохранения id
	 */
    public static function setId(int $id)
    {
        self::$id = $id;
    }

	/**
	 * Функция вывода id
	 */
    public static function id()
    {
        return self::$id;
    }
}
