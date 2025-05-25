<?php
require_once __DIR__ . '/../dao/UserDAO.php';

Flight::route('GET /users', function () {
    Flight::authenticate(); // ⛔ must be logged in
    $user = Flight::get('user');

    if ($user['role'] !== 'admin') {
        Flight::halt(403, 'Access denied');
    }

    $dao = new UserDAO(Flight::get('db'));
    Flight::json($dao->getAll());
});

Flight::route('POST /users', function () {
    Flight::authenticate();
    $user = Flight::get('user');

    if ($user['role'] !== 'admin') {
        Flight::halt(403, 'Only admins can create users');
    }

    $data = Flight::request()->data->getData();

    if (!isset($data['name'], $data['email'], $data['password'])) {
        Flight::halt(400, 'Missing required fields');
    }

    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        Flight::halt(400, 'Invalid email format');
    }

    $dao = new UserDAO(Flight::get('db'));
    $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
    $dao->create($data['name'], $data['email'], $hashedPassword);

    Flight::json(['message' => 'User created successfully']);
});

Flight::route('PUT /users', function () {
    Flight::authenticate();
    $user = Flight::get('user');

    if ($user['role'] !== 'admin') {
        Flight::halt(403, 'Only admins can update users');
    }

    $data = Flight::request()->data->getData();

    if (!isset($data['id'], $data['name'], $data['email'])) {
        Flight::halt(400, 'Missing required fields');
    }

    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        Flight::halt(400, 'Invalid email format');
    }

    $dao = new UserDAO(Flight::get('db'));
    $dao->update($data['id'], $data['name'], $data['email'], $data['password'] ?? null);

    Flight::json(['message' => 'User updated successfully']);
});

Flight::route('DELETE /users/@id', function ($id) {
    Flight::authenticate();
    $user = Flight::get('user');

    if ($user['role'] !== 'admin') {
        Flight::halt(403, 'Only admins can delete users');
    }

    $dao = new UserDAO(Flight::get('db'));
    $dao->delete($id);

    Flight::json(['message' => 'User deleted successfully']);
});
