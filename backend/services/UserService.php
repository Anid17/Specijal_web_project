<?php
require_once __DIR__ . '/../daos/UserDAO.php';

class UserService {
    private $dao;

    public function __construct($db) {
        $this->dao = new UserDAO($db);
    }

    public function getAllUsers() {
        return $this->dao->getAll();
    }

    public function getUserById($id) {
        return $this->dao->getById($id);
    }

    public function createUser($data) {
        if (!isset($data['name'], $data['email'], $data['password'])) {
            throw new Exception("Missing required fields");
        }
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid email format");
        }
        return $this->dao->create($data['name'], $data['email'], $data['password']);
    }

    public function updateUser($id, $data) {
        return $this->dao->update($id, $data);
    }

    public function deleteUser($id) {
        return $this->dao->delete($id);
    }
}
