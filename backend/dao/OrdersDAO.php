<?php
class OrderDAO {
    private $conn;
    private $table = "orders";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        $query = "SELECT * FROM " . $this->table;
        return $this->conn->query($query)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $query = "INSERT INTO orders (user_id, product_id, quantity, total_price, order_date) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$data['user_id'], $data['product_id'], $data['quantity'], $data['total_price'], $data['order_date']]);
    }

    public function update($data) {
        $query = "UPDATE orders SET user_id = ?, product_id = ?, quantity = ?, total_price = ?, order_date = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$data['user_id'], $data['product_id'], $data['quantity'], $data['total_price'], $data['order_date'], $data['id']]);
    }

    public function delete($id) {
        $query = "DELETE FROM orders WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$id]);
    }
}
