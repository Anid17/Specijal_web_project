<?php
require_once '../config/database.php';
require_once '../dao/OrderDAO.php';
require_once '../services/AuthService.php';
require_once '../middleware/JwtMiddleware.php';

$dao = new OrderDAO((new Database())->connect());
$method = $_SERVER['REQUEST_METHOD'];

header("Content-Type: application/json");

switch ($method) {
    case 'GET':
        Flight::authenticate();
        $user = Flight::get('user');

        // Admin can view all, regular users only their orders
        if ($user['role'] === 'admin') {
            echo json_encode($dao->getAll());
        } else {
            echo json_encode($dao->getByUserId($user['sub']));
        }
        break;

    case 'POST':
        Flight::authenticate();
        $user = Flight::get('user');

        $data = json_decode(file_get_contents("php://input"), true);
        $userId = $user['sub']; // Authenticated user places order

        if ($dao->create($userId, $data['total_price'])) {
            echo json_encode(["message" => "Order created"]);
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Order creation failed"]);
        }
        break;

    case 'PUT':
        Flight::authenticate();
        $user = Flight::get('user');

        if ($user['role'] !== 'admin') {
            http_response_code(403);
            echo json_encode(["message" => "Only admins can update orders"]);
            exit;
        }

        $data = json_decode(file_get_contents("php://input"), true);
        if ($dao->update($data['id'], $data['user_id'], $data['total_price'])) {
            echo json_encode(["message" => "Order updated"]);
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Order update failed"]);
        }
        break;

    case 'DELETE':
        Flight::authenticate();
        $user = Flight::get('user');

        if ($user['role'] !== 'admin') {
            http_response_code(403);
            echo json_encode(["message" => "Only admins can delete orders"]);
            exit;
        }

        if (isset($_GET['id']) && $dao->delete($_GET['id'])) {
            echo json_encode(["message" => "Order deleted"]);
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Order deletion failed"]);
        }
        break;
}
