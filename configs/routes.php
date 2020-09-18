<?php

use controllers\PageController;
use controllers\BasketController;
use controllers\OrderController;
use controllers\UserController;
use controllers\admin\AdminBrandController;
use controllers\admin\AdminRoleController;
use controllers\admin\AdminModelController;
use controllers\admin\AdminOrderController;
use controllers\admin\AdminUserController;

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
    '/tels' => [new AdminModelController(), 'index'],
    '/tels/create' => [new AdminModelController(), 'create'],
    '/tels/{id}' => [new AdminModelController(), 'show'],
    '/tels/{id}/save' => [new AdminModelController(), 'save'],
    '/tels/{id}/edit' => [new AdminModelController(), 'edit'],
    '/tels/{id}/remove' => [new AdminModelController(), 'remove'],
    '/orders' => [new AdminOrderController(), 'index'],
    '/orders/{id}' => [new AdminOrderController(), 'show'],
    '/orders/{id}/edit' => [new AdminOrderController(), 'edit'],
    '/roles' => [new AdminRoleController(), 'index'],
    '/roles/create' => [new AdminRoleController(), 'create'],
    '/roles/{id}/edit' => [new AdminRoleController(), 'edit'],
    '/roles/{id}/remove' => [new AdminRoleController(), 'remove'],
    '/users' => [new AdminUserController(), 'index'],
    '/users/{id}' => [new AdminUserController(), 'show'],
    '/users/{id}/edit' => [new AdminUserController(), 'edit'],
    '/404' => [new PageController(), 'error404']
];
