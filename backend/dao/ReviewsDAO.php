<?php
class ReviewDAO {
    private $conn;
    private $table = "reviews";

    public function __construct($db) {
        $this->conn = $db;
    }

  public function getAll() {
        $stmt = $this->conn->prepare("SELECT * FROM reviews");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }  

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM reviews WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $query = "INSERT INTO reviews (product_id, user_id, rating, comment) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$data['product_id'], $data['user_id'], $data['rating'], $data['comment']]);
    }

    public function update($data) {
        $query = "UPDATE reviews SET product_id = ?, user_id = ?, rating = ?, comment = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$data['product_id'], $data['user_id'], $data['rating'], $data['comment'], $data['id']]);
    }

    public function delete($id) {
        $query = "DELETE FROM reviews WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$id]);
    }
}
    
    
    
