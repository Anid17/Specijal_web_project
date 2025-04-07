<?php
require_once '../config/Database.php';
require_once '../dao/ProductDAO.php';

$dao = new ProductDAO((new Database())->connect());
$method = $_SERVER['REQUEST_METHOD'];

header('Content-Type: application/json');

switch ($method) {
    case 'GET':
        // Fetch and return all products
        echo json_encode($dao->getAll());
        break;

    case 'POST':
        // Create a new product
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['name'], $data['description'], $data['price'])) {
            echo json_encode(["status" => "error", "message" => "Missing required fields."]);
            break;
        }

        $response = $dao->create($data['name'], $data['description'], $data['price']);
        echo json_encode($response);
        break;

    case 'PUT':
        // Update an existing product
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['id'], $data['name'], $data['description'], $data['price'])) {
            echo json_encode(["status" => "error", "message" => "Missing required fields."]);
            break;
        }

        $response = $dao->update($data['id'], $data['name'], $data['description'], $data['price']);
        echo json_encode($response);
        break;

    case 'DELETE':
        // Delete a product by ID
        $id = $_GET['id'] ?? null;
        if ($id) {
            $response = $dao->delete($id);
            echo json_encode($response);
        } else {
            echo json_encode(["status" => "error", "message" => "Product ID is required."]);
        }
        break;
}
?>
