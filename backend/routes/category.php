<?php
require_once '../config/database.php';
require_once '../dao/CategoryDAO.php';

$dao = new CategoryDAO((new Database())->connect());
$method = $_SERVER['REQUEST_METHOD'];

header("Content-Type: application/json");

/**
 * @OA\Get(
 *     path="/api/category",
 *     summary="Get all categories or a single category by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="query",
 *         description="Category ID",
 *         required=false,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(response=200, description="Success")
 * )
 *
 * @OA\Post(
 *     path="/api/category",
 *     summary="Create a new category",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name", "description"},
 *             @OA\Property(property="name", type="string"),
 *             @OA\Property(property="description", type="string")
 *         )
 *     ),
 *     @OA\Response(response=200, description="Category created")
 * )
 *
 * @OA\Put(
 *     path="/api/category",
 *     summary="Update an existing category",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"id", "name", "description"},
 *             @OA\Property(property="id", type="integer"),
 *             @OA\Property(property="name", type="string"),
 *             @OA\Property(property="description", type="string")
 *         )
 *     ),
 *     @OA\Response(response=200, description="Category updated")
 * )
 *
 * @OA\Delete(
 *     path="/api/category",
 *     summary="Delete a category",
 *     @OA\Parameter(
 *         name="id",
 *         in="query",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(response=200, description="Category deleted")
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
        if ($dao->create($data['name'], $data['description'])) {
            echo json_encode(["message" => "Category created"]);
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Category creation failed"]);
        }
        break;

    case 'PUT':
        $data = json_decode(file_get_contents("php://input"), true);
        if ($dao->update($data['id'], $data['name'], $data['description'])) {
            echo json_encode(["message" => "Category updated"]);
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Category update failed"]);
        }
        break;

    case 'DELETE':
        if (isset($_GET['id']) && $dao->delete($_GET['id'])) {
            echo json_encode(["message" => "Category deleted"]);
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Category deletion failed"]);
        }
        break;
}
