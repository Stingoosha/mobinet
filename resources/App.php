<?php
namespace resources;

use controllers\BaseController;
use models\BaseModel;

/**
 * Класс приложения
 */
class App
{
    /**
     * Функция инициализации приложения
     * @var string $routePath Путь к файлу с рутами
     * @var string $constantsPath Путь к файлу с константами
     * @var string $databasePath Путь к файлу с настройками подключения к базе данных
     * @var string $validationPath Путь к файлу с правилами валидации
     * @return void
     */
    public static function init(string $routePath, string $constantsPath, string $databasePath, string $validationPath) :void
    {
        Router::init($routePath);
        BaseController::init($constantsPath);
        BaseModel::init($databasePath);
        Validator::init($validationPath);
    }
}
