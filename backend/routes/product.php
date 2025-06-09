<?php
require_once __DIR__ . '/../dao/ProductDAO.php';

Flight::route('GET /api/products', function () {
    $dao = new ProductDAO(Flight::get('db'));
    Flight::json($dao->getAll());
});

Flight::route('GET /api/products/@id', function ($id) {
    $dao = new ProductDAO(Flight::get('db'));
    $product = $dao->getById($id);
    if ($product) {
        Flight::json($product);
    } else {
        Flight::halt(404, json_encode(["error" => "Product not found"]));
    }
});

Flight::route('POST /api/products', function () {
    Flight::authenticate(); 
    $user = Flight::get('user');

    if ($user['role'] !== 'admin') {
        Flight::halt(403, 'Only admins can add products');
    }

    $data = Flight::request()->data->getData();
    $dao = new ProductDAO(Flight::get('db'));
    Flight::json($dao->create($data['name'], $data['description'], $data['price']));
});

Flight::route('PUT /api/products', function () {
    Flight::authenticate();
    $user = Flight::get('user');

    if ($user['role'] !== 'admin') {
        Flight::halt(403, 'Only admins can update products');
    }

    $data = Flight::request()->data->getData();
    $dao = new ProductDAO(Flight::get('db'));
    Flight::json($dao->update($data['id'], $data['name'], $data['description'], $data['price']));
});

Flight::route('DELETE /api/products/@id', function ($id) {
    Flight::authenticate();
    $user = Flight::get('user');

    if ($user['role'] !== 'admin') {
        Flight::halt(403, 'Only admins can delete products');
    }

    $dao = new ProductDAO(Flight::get('db'));
    Flight::json($dao->delete($id));
});
