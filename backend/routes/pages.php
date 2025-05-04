<?php
require_once __DIR__ . '/../services/ProductService.php';
require_once __DIR__ . '/../services/CategoryService.php';

Flight::route('/', function () {
    $productService = new ProductService(Flight::get('db'));
    $categoryService = new CategoryService(Flight::get('db'));

    $products = $productService->getAllProducts();
    $categories = $categoryService->getAllCategories();

    Flight::render('index.php', [
        'products' => $products,
        'categories' => $categories
    ]);
});
