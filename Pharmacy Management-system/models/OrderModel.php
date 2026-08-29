<?php
require_once 'models/Database.php';

class OrderModel {
    private $conn;

    public function __construct() {
        $this->conn = Database::connect();
    }

    public function create($userId, $total, $address, $paymentMethod) {
        $stmt = $this->conn->prepare("INSERT INTO orders (user_id, total_amount, address, payment_method, status) VALUES (?,?,?,?, 'pending')");
        $stmt->bind_param("idss", $userId, $total, $address, $paymentMethod);
        $stmt->execute();
        return $this->conn->insert_id;
    }

    public function addItem($orderId, $medicineId, $qty, $price) {
        $stmt = $this->conn->prepare("INSERT INTO order_items (order_id, medicine_id, quantity, price) VALUES (?,?,?,?)");
        $stmt->bind_param("iiid", $orderId, $medicineId, $qty, $price);
        return $stmt->execute();
    }

    public function addPayment($orderId, $amount, $method) {
        $stmt = $this->conn->prepare("INSERT INTO payments (order_id, amount, method) VALUES (?,?,?)");
        $stmt->bind_param("ids", $orderId, $amount, $method);
        return $stmt->execute();
    }

    public function getByUser($userId) {
        $stmt = $this->conn->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY id DESC");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function getRecentByUser($userId, $limit = 5) {
        $stmt = $this->conn->prepare("SELECT * FROM orders WHERE user_id=? ORDER BY id DESC LIMIT ?");
        $stmt->bind_param("ii", $userId, $limit);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function getItemsForOrder($orderId) {
        $stmt = $this->conn->prepare("SELECT oi.*, m.name FROM order_items oi JOIN medicines m ON oi.medicine_id = m.id WHERE oi.order_id = ?");
        $stmt->bind_param("i", $orderId);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function getAll() {
        return $this->conn->query("SELECT o.*, u.name AS user_name FROM orders o JOIN users u ON o.user_id = u.id ORDER BY o.id DESC");
    }

    public function getByStatus($status) {
        $stmt = $this->conn->prepare("SELECT o.*, u.name AS user_name FROM orders o JOIN users u ON o.user_id=u.id WHERE o.status=? ORDER BY o.id DESC");
        $stmt->bind_param("s", $status);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function getByDeliveryman($deliverymanId, $status) {
        $stmt = $this->conn->prepare("SELECT o.*, u.name AS user_name FROM orders o JOIN users u ON o.user_id=u.id WHERE o.deliveryman_id=? AND o.status=? ORDER BY o.id");
        $stmt->bind_param("is", $deliverymanId, $status);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function updateStatus($orderId, $status) {
        $stmt = $this->conn->prepare("UPDATE orders SET status=? WHERE id=?");
        $stmt->bind_param("si", $status, $orderId);
        return $stmt->execute();
    }

    public function assignDeliveryman($orderId, $deliverymanId) {
        $stmt = $this->conn->prepare("UPDATE orders SET deliveryman_id=?, status='out_for_delivery' WHERE id=? AND status='approved'");
        $stmt->bind_param("ii", $deliverymanId, $orderId);
        return $stmt->execute();
    }

    public function updateStatusByDeliveryman($orderId, $deliverymanId, $status) {
        $stmt = $this->conn->prepare("UPDATE orders SET status=? WHERE id=? AND deliveryman_id=?");
        $stmt->bind_param("sii", $status, $orderId, $deliverymanId);
        return $stmt->execute();
    }

    public function count() {
        return $this->conn->query("SELECT COUNT(*) c FROM orders")->fetch_assoc()['c'];
    }

    public function totalSales($condition = "status='delivered'") {
        return $this->conn->query("SELECT IFNULL(SUM(total_amount),0) s FROM orders WHERE $condition")->fetch_assoc()['s'];
    }
}
