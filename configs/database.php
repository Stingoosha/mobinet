<?php
// echo 'configs/database';die;
return [
    'DRIVER' => 'mysql', // драйвер БД
    'HOST' => 'localhost', // адрес хоста БД
    'DBNAME' => 'mobinet', // название БД
    'LOGIN' => 'root', // пользователь БД
    'PASS' => '', // пароль в БД
    'ENCODE' => 'UTF8', // установка кодирования
    'AS_ARRAY' => PDO::FETCH_ASSOC, // вывод данных в виде массива
    'AS_OBJECT' => PDO::FETCH_CLASS, // вывод данных в виде объекта
    'SALT' => 'some_salt_to_encrypt_login_using_md5_function' // соль
];
