<?php
require_once __DIR__ . '/../dao/ProductDAO.php';

/**
 * @OA\Get(
 *     path="/api/products",
 *     summary="Get all products",
 *     @OA\Response(
 *         response=200,
 *         description="List of products"
 *     )
 * )
 */
Flight::route('GET /api/products', function () {
    $dao = new ProductDAO(Flight::get('db'));
    Flight::json($dao->getAll());
});

/**
 * @OA\Get(
 *     path="/api/products/{id}",
 *     summary="Get product by ID",
 *     @OA\Parameter(
 *         in="path",
 *         name="id",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Product found"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Product not found"
 *     )
 * )
 */
Flight::route('GET /api/products/@id', function ($id) {
    $dao = new ProductDAO(Flight::get('db'));
    $product = $dao->getById($id);
    if ($product) {
        Flight::json($product);
    } else {
        Flight::halt(404, json_encode(["error" => "Product not found"]));
    }
});

/**
 * @OA\Post(
 *     path="/api/products",
 *     summary="Create new product",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name","description","price"},
 *             @OA\Property(property="name", type="string"),
 *             @OA\Property(property="description", type="string"),
 *             @OA\Property(property="price", type="number")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Product created"
 *     )
 * )
 */
Flight::route('POST /api/products', function () {
    $data = Flight::request()->data->getData();
    $dao = new ProductDAO(Flight::get('db'));
    Flight::json($dao->create($data['name'], $data['description'], $data['price']));
});

/**
 * @OA\Put(
 *     path="/api/products",
 *     summary="Update a product",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"id","name","description","price"},
 *             @OA\Property(property="id", type="integer"),
 *             @OA\Property(property="name", type="string"),
 *             @OA\Property(property="description", type="string"),
 *             @OA\Property(property="price", type="number")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Product updated"
 *     )
 * )
 */
Flight::route('PUT /api/products', function () {
    $data = Flight::request()->data->getData();
    $dao = new ProductDAO(Flight::get('db'));
    Flight::json($dao->update($data['id'], $data['name'], $data['description'], $data['price']));
});

/**
 * @OA\Delete(
 *     path="/api/products/{id}",
 *     summary="Delete product",
 *     @OA\Parameter(
 *         in="path",
 *         name="id",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Product deleted"
 *     )
 * )
 */
Flight::route('DELETE /api/products/@id', function ($id) {
    $dao = new ProductDAO(Flight::get('db'));
    Flight::json($dao->delete($id));
});
