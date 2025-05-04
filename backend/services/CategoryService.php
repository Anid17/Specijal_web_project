<?php
require_once __DIR__ . '/../daos/CategoryDAO.php';

class CategoryService {
    private $dao;

    public function __construct($db) {
        $this->dao = new CategoryDAO($db);
    }

    public function getAllCategories() {
        return $this->dao->getAll();
    }

    public function getCategoryById($id) {
        return $this->dao->getById($id);
    }

    public function createCategory($data) {
        if (!isset($data['name'])) {
            throw new Exception("Missing category name");
        }
        return $this->dao->create($data['name']);
    }

    public function updateCategory($id, $data) {
        return $this->dao->update($id, $data);
    }

    public function deleteCategory($id) {
        return $this->dao->delete($id);
    }
}
