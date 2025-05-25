<?php
require_once '../config/database.php';
require_once '../dao/CategoryDAO.php';
require_once '../services/AuthService.php';
require_once '../middleware/JwtMiddleware.php';

$dao = new CategoryDAO((new Database())->connect());
$method = $_SERVER['REQUEST_METHOD'];

header("Content-Type: application/json");

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            echo json_encode($dao->getById($_GET['id']));
        } else {
            echo json_encode($dao->getAll());
        }
        break;

    case 'POST':
        Flight::authenticate();
        $user = Flight::get('user');

        if ($user['role'] !== 'admin') {
            http_response_code(403);
            echo json_encode(["message" => "Only admins can create categories"]);
            exit;
        }

        $data = json_decode(file_get_contents("php://input"), true);
        if ($dao->create($data['name'], $data['description'])) {
            echo json_encode(["message" => "Category created"]);
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Category creation failed"]);
        }
        break;

    case 'PUT':
        Flight::authenticate();
        $user = Flight::get('user');

        if ($user['role'] !== 'admin') {
            http_response_code(403);
            echo json_encode(["message" => "Only admins can update categories"]);
            exit;
        }

        $data = json_decode(file_get_contents("php://input"), true);
        if ($dao->update($data['id'], $data['name'], $data['description'])) {
            echo json_encode(["message" => "Category updated"]);
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Category update failed"]);
        }
        break;

    case 'DELETE':
        Flight::authenticate();
        $user = Flight::get('user');

        if ($user['role'] !== 'admin') {
            http_response_code(403);
            echo json_encode(["message" => "Only admins can delete categories"]);
            exit;
        }

        if (isset($_GET['id']) && $dao->delete($_GET['id'])) {
            echo json_encode(["message" => "Category deleted"]);
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Category deletion failed"]);
        }
        break;
}
