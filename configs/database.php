<?php

return [
    'DRIVER' => 'mysql',
    'HOST' => 'localhost',
    'DBNAME' => 'mobinet',
    'LOGIN' => 'root',
    'PASS' => '',
    'ENCODE' => 'UTF8',
    'AS_ARRAY' => PDO::FETCH_ASSOC,
    'AS_OBJECT' => PDO::FETCH_CLASS,
    'SALT' => 'some_salt_to_encrypt_login_using_md5_function'
];
