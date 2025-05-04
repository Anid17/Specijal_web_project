<?php
require_once __DIR__ . '/../daos/ProductDAO.php';

class ProductService {
    private $dao;

    public function __construct($db) {
        $this->dao = new ProductDAO($db);
    }

    public function getAllProducts() {
        return $this->dao->getAll();
    }

    public function getProductById($id) {
        return $this->dao->getById($id);
    }

    public function createProduct($data) {
        if (!isset($data['name'], $data['price'])) {
            throw new Exception("Missing product fields");
        }
        return $this->dao->create($data['name'], $data['price'], $data['description'] ?? '');
    }

    public function updateProduct($id, $data) {
        return $this->dao->update($id, $data);
    }

    public function deleteProduct($id) {
        return $this->dao->delete($id);
    }
}
