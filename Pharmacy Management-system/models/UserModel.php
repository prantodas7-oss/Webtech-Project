<?php
require_once 'models/Database.php';

class UserModel {
    private $conn;

    public function __construct() {
        $this->conn = Database::connect();
    }

    public function findByEmail($email) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function create($name, $email, $hashedPassword) {
        $stmt = $this->conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, 'user')");
        $stmt->bind_param("sss", $name, $email, $hashedPassword);
        return $stmt->execute();
    }

    public function getAll() {
        return $this->conn->query("SELECT * FROM users ORDER BY id DESC");
    }

    public function updateRole($id, $role) {
        $stmt = $this->conn->prepare("UPDATE users SET role=? WHERE id=?");
        $stmt->bind_param("si", $role, $id);
        return $stmt->execute();
    }

    public function toggleStatus($id) {
        $this->conn->query("UPDATE users SET status = IF(status='active','inactive','active') WHERE id = " . intval($id));
    }

    public function countByRole($role) {
        $stmt = $this->conn->prepare("SELECT COUNT(*) c FROM users WHERE role=?");
        $stmt->bind_param("s", $role);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['c'];
    }
}
