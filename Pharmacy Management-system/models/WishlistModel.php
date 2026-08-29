<?php
require_once 'models/Database.php';

class WishlistModel {
    private $conn;

    public function __construct() {
        $this->conn = Database::connect();
    }

    public function add($userId, $medicineId) {
        $stmt = $this->conn->prepare("SELECT id FROM wishlist WHERE user_id=? AND medicine_id=?");
        $stmt->bind_param("ii", $userId, $medicineId);
        $stmt->execute();
        if ($stmt->get_result()->num_rows === 0) {
            $ins = $this->conn->prepare("INSERT INTO wishlist (user_id, medicine_id) VALUES (?, ?)");
            $ins->bind_param("ii", $userId, $medicineId);
            $ins->execute();
        }
    }

    public function remove($id, $userId) {
        $stmt = $this->conn->prepare("DELETE FROM wishlist WHERE id=? AND user_id=?");
        $stmt->bind_param("ii", $id, $userId);
        return $stmt->execute();
    }

    public function find($id, $userId) {
        $stmt = $this->conn->prepare("SELECT * FROM wishlist WHERE id=? AND user_id=?");
        $stmt->bind_param("ii", $id, $userId);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function getItems($userId) {
        $stmt = $this->conn->prepare("SELECT w.id AS wishlist_id, m.id AS medicine_id, m.name, m.price, m.image
                                       FROM wishlist w JOIN medicines m ON w.medicine_id = m.id WHERE w.user_id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        return $stmt->get_result();
    }
}
