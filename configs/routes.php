<?php

use controllers\PageController;
use controllers\BasketController;
use controllers\OrderController;
use controllers\UserController;
use controllers\admin\AdminBrandController;

return [
    '/' => [new PageController(), 'index'],
    '/index.php' => [new PageController(), 'index'],
    '/search' => [new PageController(), 'search'],
    '/phones' => [new PageController(), 'catalog'],
    '/phones/{id}' => [new PageController(), 'show'],
    '/showMore' => [new PageController(), 'showMore'],
    '/selectBrand' => [new PageController(), 'selectBrand'],
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
    '/cabinet/edit' => [new UserController(), 'edit'],
    '/brands' => [new AdminBrandController(), 'index'],
    '/brands/create' => [new AdminBrandController(), 'create'],
    '/brands/{id}/edit' => [new AdminBrandController(), 'edit'],
    '/brands/{id}/remove' => [new AdminBrandController(), 'remove'],
    // '/models' => [new AdminController(), 'models'],
    // '/orders' => [new AdminController(), 'orders'],
    // '/roles' => [new AdminController(), 'roles'],
    // '/users' => [new AdminController(), 'users'],
    '/404' => [new PageController(), 'error404']
];
