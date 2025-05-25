<?php
require_once __DIR__ . '/../services/AuthService.php';

Flight::map('authenticate', function () {
    $headers = getallheaders();

    if (!isset($headers['Authorization'])) {
        Flight::halt(401, 'Missing Authorization header');
    }

    $token = str_replace('Bearer ', '', $headers['Authorization']);

    try {
        $decoded = AuthService::decodeJWT($token);
        Flight::set('user', (array)$decoded); // attach user info to Flight
    } catch (Exception $e) {
        Flight::halt(401, 'Invalid or expired token: ' . $e->getMessage());
    }
});
