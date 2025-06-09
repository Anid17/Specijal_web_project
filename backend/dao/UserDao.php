<?php
class UserDAO {
    private $conn;
    private $table = "users";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create($name, $email, $password) {
        try {
            $sql = "INSERT INTO " . $this->table . " (name, email, password) VALUES (:name, :email, :password)";
            $stmt = $this->conn->prepare($sql);

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashedPassword);

            return $stmt->execute();
        } catch (Exception $e) {
            throw new Exception("Error during user creation: " . $e->getMessage());
        }
    }

    public function getAll() {
        try {
            $sql = "SELECT id, name, email, created_at FROM " . $this->table;
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw new Exception("Error fetching users: " . $e->getMessage());
        }
    }

    public function update($id, $name, $email, $password = null) {
        try {
            if ($password) {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $sql = "UPDATE " . $this->table . " SET name = :name, email = :email, password = :password WHERE id = :id";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':password', $hashedPassword);
            } else {
                $sql = "UPDATE " . $this->table . " SET name = :name, email = :email WHERE id = :id";
                $stmt = $this->conn->prepare($sql);
            }

            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch (Exception $e) {
            throw new Exception("Error updating user: " . $e->getMessage());
        }
    }

    public function delete($id) {
        try {
            $sql = "DELETE FROM " . $this->table . " WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch (Exception $e) {
            throw new Exception("Error deleting user: " . $e->getMessage());
        }
    }

    public function get_user_by_email($email) {
    try {
        $sql = "SELECT * FROM " . $this->table . " WHERE email = :email";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); 
    } catch (Exception $e) {
        throw new Exception("Error fetching user by email: " . $e->getMessage());
    }
}

}
?>
