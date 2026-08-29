<?php
require_once 'models/Database.php';

class CategoryModel {
    private $conn;

    public function __construct() {
        $this->conn = Database::connect();
    }

    public function getAll() {
        return $this->conn->query("SELECT * FROM categories ORDER BY name");
    }

    public function create($name) {
        $stmt = $this->conn->prepare("INSERT INTO categories (name) VALUES (?)");
        $stmt->bind_param("s", $name);
        return $stmt->execute();
    }

    public function delete($id) {
        $this->conn->query("DELETE FROM categories WHERE id = " . intval($id));
    }
}
