<?php
require_once 'models/Database.php';

class ReviewModel {
    private $conn;

    public function __construct() {
        $this->conn = Database::connect();
    }

    public function create($userId, $medicineId, $rating, $comment) {
        $stmt = $this->conn->prepare("INSERT INTO reviews (user_id, medicine_id, rating, comment) VALUES (?,?,?,?)");
        $stmt->bind_param("iiis", $userId, $medicineId, $rating, $comment);
        return $stmt->execute();
    }
}
