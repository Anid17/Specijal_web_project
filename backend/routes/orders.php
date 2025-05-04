<?php
require_once '../config/database.php';
require_once '../dao/OrderDAO.php';

$dao = new OrderDAO((new Database())->connect());
$method = $_SERVER['REQUEST_METHOD'];

header("Content-Type: application/json");

/**
 * @OA\Get(
 *     path="/api/order",
 *     summary="Get all orders or a single order by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="query",
 *         description="Order ID",
 *         required=false,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(response=200, description="Success")
 * )
 *
 * @OA\Post(
 *     path="/api/order",
 *     summary="Create a new order",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"user_id", "total_price"},
 *             @OA\Property(property="user_id", type="integer"),
 *             @OA\Property(property="total_price", type="number", format="float")
 *         )
 *     ),
 *     @OA\Response(response=200, description="Order created")
 * )
 *
 * @OA\Put(
 *     path="/api/order",
 *     summary="Update an existing order",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"id", "user_id", "total_price"},
 *             @OA\Property(property="id", type="integer"),
 *             @OA\Property(property="user_id", type="integer"),
 *             @OA\Property(property="total_price", type="number", format="float")
 *         )
 *     ),
 *     @OA\Response(response=200, description="Order updated")
 * )
 *
 * @OA\Delete(
 *     path="/api/order",
 *     summary="Delete an order",
 *     @OA\Parameter(
 *         name="id",
 *         in="query",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(response=200, description="Order deleted")
 * )
 */

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            echo json_encode($dao->getById($_GET['id']));
        } else {
            echo json_encode($dao->getAll());
        }
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        if ($dao->create($data['user_id'], $data['total_price'])) {
            echo json_encode(["message" => "Order created"]);
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Order creation failed"]);
        }
        break;

    case 'PUT':
        $data = json_decode(file_get_contents("php://input"), true);
        if ($dao->update($data['id'], $data['user_id'], $data['total_price'])) {
            echo json_encode(["message" => "Order updated"]);
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Order update failed"]);
        }
        break;

    case 'DELETE':
        if (isset($_GET['id']) && $dao->delete($_GET['id'])) {
            echo json_encode(["message" => "Order deleted"]);
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Order deletion failed"]);
        }
        break;
}
