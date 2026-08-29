<?php
require_once 'models/Database.php';

class CartModel {
    private $conn;

    public function __construct() {
        $this->conn = Database::connect();
    }

    public function add($userId, $medicineId) {
        $stmt = $this->conn->prepare("SELECT id, quantity FROM cart WHERE user_id=? AND medicine_id=?");
        $stmt->bind_param("ii", $userId, $medicineId);
        $stmt->execute();
        $existing = $stmt->get_result()->fetch_assoc();

        if ($existing) {
            $newQty = $existing['quantity'] + 1;
            $upd = $this->conn->prepare("UPDATE cart SET quantity=? WHERE id=?");
            $upd->bind_param("ii", $newQty, $existing['id']);
            $upd->execute();
        } else {
            $ins = $this->conn->prepare("INSERT INTO cart (user_id, medicine_id, quantity) VALUES (?, ?, 1)");
            $ins->bind_param("ii", $userId, $medicineId);
            $ins->execute();
        }
    }

    public function updateQuantity($cartId, $userId, $qty) {
        $stmt = $this->conn->prepare("UPDATE cart SET quantity=? WHERE id=? AND user_id=?");
        $stmt->bind_param("iii", $qty, $cartId, $userId);
        return $stmt->execute();
    }

    public function remove($cartId, $userId) {
        $stmt = $this->conn->prepare("DELETE FROM cart WHERE id=? AND user_id=?");
        $stmt->bind_param("ii", $cartId, $userId);
        return $stmt->execute();
    }

    public function getItems($userId) {
        $stmt = $this->conn->prepare("SELECT c.id AS cart_id, c.quantity, m.id AS medicine_id, m.name, m.price, m.stock
                                       FROM cart c JOIN medicines m ON c.medicine_id = m.id WHERE c.user_id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function count($userId) {
        $stmt = $this->conn->prepare("SELECT IFNULL(SUM(quantity),0) c FROM cart WHERE user_id=?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['c'];
    }

    public function clear($userId) {
        $this->conn->query("DELETE FROM cart WHERE user_id = " . intval($userId));
    }
}
