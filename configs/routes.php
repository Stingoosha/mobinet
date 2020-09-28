<?php

use controllers\PageController;
use controllers\BasketController;
use controllers\OrderController;
use controllers\UserController;
use controllers\admin\AdminBrandController;
use controllers\admin\AdminDiscountController;
use controllers\admin\AdminRoleController;
use controllers\admin\AdminModelController;
use controllers\admin\AdminOrderController;
use controllers\admin\AdminUserController;

return [
    '/' => [PageController::class, 'index'],
    '/index.php' => [PageController::class, 'index'],
    '/search' => [PageController::class, 'search'],
    '/phones' => [PageController::class, 'catalog'],
    '/phones/{id}' => [PageController::class, 'show'],
    '/showMore' => [PageController::class, 'showMore'],
    '/selectBrand' => [PageController::class, 'selectBrand'],
    '/contacts' => [PageController::class, 'contacts'],
    '/tobasket' => [BasketController::class, 'tobasket'],
    '/basket' => [BasketController::class, 'index'],
    '/basket/{id}/remove' => [BasketController::class, 'remove'],
    '/order' => [OrderController::class, 'index'],
    '/order/save' => [OrderController::class, 'save'],
    '/login' => [UserController::class, 'login'],
    '/registry' => [UserController::class, 'reg'],
    '/logout' => [UserController::class, 'logout'],
    '/cabinet' => [UserController::class, 'cabinet'],
    '/cabinet/edit' => [UserController::class, 'edit'],
    '/brands' => [AdminBrandController::class, 'index'],
    '/brands/create' => [AdminBrandController::class, 'create'],
    '/brands/{id}/edit' => [AdminBrandController::class, 'edit'],
    '/brands/{id}/remove' => [AdminBrandController::class, 'remove'],
    '/tels' => [AdminModelController::class, 'index'],
    '/tels/create' => [AdminModelController::class, 'create'],
    '/tels/{id}' => [AdminModelController::class, 'show'],
    '/tels/{id}/save' => [AdminModelController::class, 'save'],
    '/tels/{id}/edit' => [AdminModelController::class, 'edit'],
    '/tels/{id}/remove' => [AdminModelController::class, 'remove'],
    '/orders' => [AdminOrderController::class, 'index'],
    '/orders/{id}' => [AdminOrderController::class, 'show'],
    '/orders/{id}/edit' => [AdminOrderController::class, 'edit'],
    '/roles' => [AdminRoleController::class, 'index'],
    '/roles/create' => [AdminRoleController::class, 'create'],
    '/roles/{id}/edit' => [AdminRoleController::class, 'edit'],
    '/roles/{id}/remove' => [AdminRoleController::class, 'remove'],
    '/discounts' => [AdminDiscountController::class, 'index'],
    '/discounts/create' => [AdminDiscountController::class, 'create'],
    '/discounts/{id}' => [AdminDiscountController::class, 'show'],
    '/discounts/{id}/save' => [AdminDiscountController::class, 'save'],
    '/discounts/{id}/edit' => [AdminDiscountController::class, 'edit'],
    '/discounts/{id}/remove' => [AdminDiscountController::class, 'remove'],
    '/users' => [AdminUserController::class, 'index'],
    '/users/{id}' => [AdminUserController::class, 'show'],
    '/users/{id}/edit' => [AdminUserController::class, 'edit'],
    '/404' => [PageController::class, 'error404']
];
