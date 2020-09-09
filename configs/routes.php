<?php

use controllers\PageController;
use controllers\BasketController;
use controllers\OrderController;

return [
    '/' => [new PageController(), 'index'],
    '/index.php' => [new PageController(), 'index'],
    '/phones' => [new PageController(), 'catalog'],
    '/phones/{id}' => [new PageController(), 'show'],
    '/getPhones' => [new PageController(), 'getPhones'],
    '/contacts' => [new PageController(), 'contacts'],
    '/tobasket' => [new PageController(), 'tobasket'],
    '/basket' => [new BasketController(), 'index'],
    '/basket/{id}/remove' => [new BasketController(), 'remove'],
    '/order' => [new OrderController(), 'index'],
    '/order/save' => [new OrderController(), 'save'],
    '/404' => [new PageController(), 'error404']
];
