<?php
require_once '../config/database.php';
require_once '../dao/ReviewDAO.php';
require_once '../services/AuthService.php';
require_once '../middleware/JwtMiddleware.php';

$dao = new ReviewDAO((new Database())->connect());
$method = $_SERVER['REQUEST_METHOD'];

header("Content-Type: application/json");

switch ($method) {
    case 'GET':
        // Public access
        if (isset($_GET['id'])) {
            echo json_encode($dao->getById($_GET['id']));
        } else {
            echo json_encode($dao->getAll());
        }
        break;

    case 'POST':
        Flight::authenticate();
        $user = Flight::get('user');

        $data = json_decode(file_get_contents("php://input"), true);

        // Use authenticated user's ID, ignore sent `user_id`
        $userId = $user['sub'];
        if ($dao->create($data['product_id'], $userId, $data['rating'], $data['comment'])) {
            echo json_encode(["message" => "Review created"]);
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Review creation failed"]);
        }
        break;

    case 'PUT':
        Flight::authenticate();
        $user = Flight::get('user');

        if ($user['role'] !== 'admin') {
            http_response_code(403);
            echo json_encode(["message" => "Only admins can update reviews"]);
            exit;
        }

        $data = json_decode(file_get_contents("php://input"), true);
        if ($dao->update($data['id'], $data['product_id'], $data['user_id'], $data['rating'], $data['comment'])) {
            echo json_encode(["message" => "Review updated"]);
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Review update failed"]);
        }
        break;

    case 'DELETE':
        Flight::authenticate();
        $user = Flight::get('user');

        if ($user['role'] !== 'admin') {
            http_response_code(403);
            echo json_encode(["message" => "Only admins can delete reviews"]);
            exit;
        }

        if (isset($_GET['id']) && $dao->delete($_GET['id'])) {
            echo json_encode(["message" => "Review deleted"]);
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Review deletion failed"]);
        }
        break;
}
