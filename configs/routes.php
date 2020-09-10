<?php

use controllers\PageController;
use controllers\BasketController;
use controllers\OrderController;
use controllers\UserController;

return [
    '/' => [new PageController(), 'index'],
    '/index.php' => [new PageController(), 'index'],
    '/phones' => [new PageController(), 'catalog'],
    '/phones/{id}' => [new PageController(), 'show'],
    '/getPhones' => [new PageController(), 'getPhones'],
    '/contacts' => [new PageController(), 'contacts'],
    '/tobasket' => [new BasketController(), 'tobasket'],
    '/basket' => [new BasketController(), 'index'],
    '/basket/{id}/remove' => [new BasketController(), 'remove'],
    '/order' => [new OrderController(), 'index'],
    '/order/save' => [new OrderController(), 'save'],
    '/auth' => [new UserController(), 'auth'],
    '/registry' => [new UserController(), 'reg'],
    '/404' => [new PageController(), 'error404']
];
