<?php

use controllers\PageController;
use controllers\BasketController;
use controllers\OrderController;
use controllers\UserController;

return [
    '/' => [new PageController(), 'index'],
    '/index.php' => [new PageController(), 'index'],
    '/search' => [new PageController(), 'search'],
    '/phones' => [new PageController(), 'catalog'],
    '/phones/{id}' => [new PageController(), 'show'],
    '/showMore' => [new PageController(), 'showMore'],
    '/selectBrend' => [new PageController(), 'selectBrend'],
    '/contacts' => [new PageController(), 'contacts'],
    '/tobasket' => [new BasketController(), 'tobasket'],
    '/basket' => [new BasketController(), 'index'],
    '/basket/{id}/remove' => [new BasketController(), 'remove'],
    '/order' => [new OrderController(), 'index'],
    '/order/save' => [new OrderController(), 'save'],
    '/login' => [new UserController(), 'login'],
    '/registry' => [new UserController(), 'reg'],
    '/logout' => [new UserController(), 'logout'],
    '/cabinet' => [new UserController(), 'cabinet'],
    '/cabinet/change' => [new UserController(), 'change'],
    '/404' => [new PageController(), 'error404']
];
