<?php
require_once '../config/database.php';
require_once '../dao/ReviewDAO.php';

$dao = new ReviewDAO((new Database())->connect());
$method = $_SERVER['REQUEST_METHOD'];

header("Content-Type: application/json");

/**
 * @OA\Get(
 *     path="/api/review",
 *     summary="Get all reviews or a review by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="query",
 *         description="Review ID",
 *         required=false,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(response=200, description="Success")
 * )
 *
 * @OA\Post(
 *     path="/api/review",
 *     summary="Create a new review",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"product_id", "user_id", "rating", "comment"},
 *             @OA\Property(property="product_id", type="integer"),
 *             @OA\Property(property="user_id", type="integer"),
 *             @OA\Property(property="rating", type="number", format="float"),
 *             @OA\Property(property="comment", type="string")
 *         )
 *     ),
 *     @OA\Response(response=200, description="Review created")
 * )
 *
 * @OA\Put(
 *     path="/api/review",
 *     summary="Update a review",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"id", "product_id", "user_id", "rating", "comment"},
 *             @OA\Property(property="id", type="integer"),
 *             @OA\Property(property="product_id", type="integer"),
 *             @OA\Property(property="user_id", type="integer"),
 *             @OA\Property(property="rating", type="number", format="float"),
 *             @OA\Property(property="comment", type="string")
 *         )
 *     ),
 *     @OA\Response(response=200, description="Review updated")
 * )
 *
 * @OA\Delete(
 *     path="/api/review",
 *     summary="Delete a review",
 *     @OA\Parameter(
 *         name="id",
 *         in="query",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(response=200, description="Review deleted")
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
        if ($dao->create($data['product_id'], $data['user_id'], $data['rating'], $data['comment'])) {
            echo json_encode(["message" => "Review created"]);
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Review creation failed"]);
        }
        break;

    case 'PUT':
        $data = json_decode(file_get_contents("php://input"), true);
        if ($dao->update($data['id'], $data['product_id'], $data['user_id'], $data['rating'], $data['comment'])) {
            echo json_encode(["message" => "Review updated"]);
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Review update failed"]);
        }
        break;

    case 'DELETE':
        if (isset($_GET['id']) && $dao->delete($_GET['id'])) {
            echo json_encode(["message" => "Review deleted"]);
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Review deletion failed"]);
        }
        break;
}
