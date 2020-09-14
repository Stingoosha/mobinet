<?php

namespace resources;

use controllers\BaseController;
use models\BaseModel;

class App
{
    public static function init(string $routePath, string $constantsPath, string $databasePath, string $validationPath)
    {
        Router::init($routePath);
        BaseController::init($constantsPath);
        BaseModel::init($databasePath);
        Validator::init($validationPath);
    }
}
