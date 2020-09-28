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
     * @var int $id сохраняемый id
	 */
    public static function setId(int $id)
    {
        self::$id = $id;
    }

	/**
	 * Функция вывода id
     * @return int
	 */
    public static function id() :int
    {
        return self::$id;
    }
}
