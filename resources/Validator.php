<?php
namespace resources;

/**
 * Класс, отвечающий за валидацию вводимых данных пользователем
 */
class Validator
{
    /**
     * @var array $rules Массив всех правил валидации
     */
    private static $rules = [];

    /**
     * Функция инициализации валидатора
     * @var string $validationPath Путь к файлу со всеми правилами валидации
     * @return void
     */
    public static function init(string $validationPath) :void
    {
        self::$rules = include $validationPath;
    }
}
