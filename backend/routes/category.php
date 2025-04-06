<?php
require_once '../config/Database.php';
require_once '../dao/CategoryDAO.php';

$dao = new CategoryDAO((new Database())->connect());
$method = $_SERVER['REQUEST_METHOD'];

header('Content-Type: application/json');

switch ($method) {
    case 'GET':
        echo json_encode($dao->getAll());
        break;
    case 'POST':
        $data = json_decode(file_get_contents("php://input"));
        echo json_encode($dao->create($data));
        break;
    case 'PUT':
        $data = json_decode(file_get_contents("php://input"));
        echo json_encode($dao->update($data));
        break;
    case 'DELETE':
        $id = $_GET['id'] ?? null;
        echo json_encode($dao->delete($id));
        break;
}
?>
