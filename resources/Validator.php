<?php

namespace resources;

class Validator
{
    private static $rules = []; // массив правил валидации

    public static function init(string $validationPath)
    {
        self::$rules = include $validationPath;
    }
}
