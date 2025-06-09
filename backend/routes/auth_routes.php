<?php
require_once __DIR__ . '/../services/AuthService.php';
require_once __DIR__ . '/../dao/UserDao.php';

Flight::route('POST /register', function () {
    $data = Flight::request()->data->getData();
    $db = Flight::get('db'); // Get database connection
    $userDao = new UserDAO($db);

    // Check if user with the same email already exists
    if ($userDao->get_user_by_email($data['email'])) {
        Flight::halt(409, 'Email already exists');
    }

    // Hash  password
    $hashedPassword = AuthService::hashPassword($data['password']);
    $userDao->create($data['name'], $data['email'], $hashedPassword);

    // Optionally fetch and return the new user
    $user = $userDao->get_user_by_email($data['email']);
    unset($user['password']);
    Flight::json($user);
});

Flight::route('POST /login', function () {
    $data = Flight::request()->data->getData();
    $db = Flight::get('db');
    $userDao = new UserDAO($db);

    $user = $userDao->get_user_by_email($data['email']);

    if (!$user || !AuthService::verifyPassword($data['password'], $user['password'])) {
        Flight::halt(401, 'Invalid email or password');
    }

    $token = AuthService::generateJWT($user);
    unset($user['password']);
    Flight::json([
        'token' => $token,
        'user' => $user
    ]);
});
