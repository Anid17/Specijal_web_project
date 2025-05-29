<?php
require_once __DIR__ . '/../daos/OrderDAO.php';

class OrderService {
    private $dao;

    public function __construct($db) {
        $this->dao = new OrderDAO($db);
    }

    public function getAllOrders() {
        return $this->dao->getAll();
    }

    public function getOrderById($id) {
        return $this->dao->getById($id);
    }

    public function createOrder($data) {
        if (!isset($data['user_id'], $data['product_id'], $data['quantity'])) {
            throw new Exception("Missing order fields");
        }
        return $this->dao->create($data['user_id'], $data['product_id'], $data['quantity']);
    }

    public function updateOrder($id, $data) {
        return $this->dao->update($id, $data);
    }

    public function deleteOrder($id) {
        return $this->dao->delete($id);
    }
}
