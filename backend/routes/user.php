<?php
require_once '../config/Database.php';
require_once '../dao/UserDAO.php';

$dao = new UserDAO((new Database())->connect());
$method = $_SERVER['REQUEST_METHOD'];

header('Content-Type: application/json');

switch ($method) {
    case 'GET':
        try {
            $users = $dao->getAll();
            echo json_encode(["status" => "success", "data" => $users]);
        } catch (Exception $e) {
            echo json_encode(["status" => "error", "message" => "Failed to fetch users: " . $e->getMessage()]);
        }
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['name'], $data['email'], $data['password'])) {
            echo json_encode(["status" => "error", "message" => "Missing required fields."]);
            break;
        }

        // Validate email format
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            echo json_encode(["status" => "error", "message" => "Invalid email format."]);
            break;
        }

        try {
            $response = $dao->create($data['name'], $data['email'], $data['password']);
            echo json_encode($response ? ["status" => "success", "message" => "User created successfully."] : ["status" => "error", "message" => "Failed to create user."]);
        } catch (Exception $e) {
            echo json_encode(["status" => "error", "message" => "Error: " . $e->getMessage()]);
        }
        break;

    case 'PUT':
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['id'], $data['name'], $data['email'])) {
            echo json_encode(["status" => "error", "message" => "Missing required fields."]);
            break;
        }

        // Validate email format
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            echo json_encode(["status" => "error", "message" => "Invalid email format."]);
            break;
        }

        try {
            $response = $dao->update($data['id'], $data['name'], $data['email'], $data['password'] ?? null);
            echo json_encode($response ? ["status" => "success", "message" => "User updated successfully."] : ["status" => "error", "message" => "Failed to update user."]);
        } catch (Exception $e) {
            echo json_encode(["status" => "error", "message" => "Error: " . $e->getMessage()]);
        }
        break;

    case 'DELETE':
        $id = $_GET['id'] ?? null;

        if ($id) {
            try {
                $response = $dao->delete($id);
                echo json_encode($response ? ["status" => "success", "message" => "User deleted successfully."] : ["status" => "error", "message" => "Failed to delete user."]);
            } catch (Exception $e) {
                echo json_encode(["status" => "error", "message" => "Error: " . $e->getMessage()]);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "User ID is required."]);
        }
        break;
}
?>
