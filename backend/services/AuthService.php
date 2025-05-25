<?php
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

class AuthService {
    private static $key = "your_secret_key_here"; // Replace with a secure secret!

    public static function hashPassword($password) {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public static function verifyPassword($password, $hash) {
        return password_verify($password, $hash);
    }

    public static function generateJWT($user) {
        $payload = [
            "sub" => $user['id'],
            "email" => $user['email'],
            "role" => $user['role'],
            "iat" => time(),
            "exp" => time() + (60 * 60 * 2) // 2 hours
        ];
        return JWT::encode($payload, self::$key, 'HS256');
    }

    public static function decodeJWT($token) {
        return JWT::decode($token, new Key(self::$key, 'HS256'));
    }
}
