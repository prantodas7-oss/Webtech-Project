<?php
require_once 'models/Database.php';

class MedicineModel {
    private $conn;

    public function __construct() {
        $this->conn = Database::connect();
    }

    public function getAll($search = '') {
        if ($search !== '') {
            $stmt = $this->conn->prepare("SELECT * FROM medicines WHERE name LIKE ? ORDER BY id DESC");
            $like = "%$search%";
            $stmt->bind_param("s", $like);
            $stmt->execute();
            return $stmt->get_result();
        }
        return $this->conn->query("SELECT * FROM medicines ORDER BY id DESC");
    }

    public function getAllWithCategory() {
        return $this->conn->query("SELECT m.*, c.name AS category_name FROM medicines m LEFT JOIN categories c ON m.category_id = c.id ORDER BY m.id DESC");
    }

    public function find($id) {
        $stmt = $this->conn->prepare("SELECT * FROM medicines WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function create($data) {
        $stmt = $this->conn->prepare("INSERT INTO medicines (name, category_id, description, price, stock, expiry_date, image) VALUES (?,?,?,?,?,?,?)");
        $stmt->bind_param("sisdiss", $data['name'], $data['category_id'], $data['description'], $data['price'], $data['stock'], $data['expiry_date'], $data['image']);
        return $stmt->execute();
    }

    public function update($id, $data) {
        if (!empty($data['image'])) {
            $stmt = $this->conn->prepare("UPDATE medicines SET name=?, category_id=?, description=?, price=?, stock=?, expiry_date=?, image=? WHERE id=?");
            $stmt->bind_param("sisdissi", $data['name'], $data['category_id'], $data['description'], $data['price'], $data['stock'], $data['expiry_date'], $data['image'], $id);
        } else {
            $stmt = $this->conn->prepare("UPDATE medicines SET name=?, category_id=?, description=?, price=?, stock=?, expiry_date=? WHERE id=?");
            $stmt->bind_param("sisdisi", $data['name'], $data['category_id'], $data['description'], $data['price'], $data['stock'], $data['expiry_date'], $id);
        }
        return $stmt->execute();
    }

    public function delete($id) {
        $this->conn->query("DELETE FROM medicines WHERE id = " . intval($id));
    }

    public function addStock($id, $qty) {
        $this->conn->query("UPDATE medicines SET stock = stock + " . intval($qty) . " WHERE id = " . intval($id));
    }

    public function reduceStock($id, $qty) {
        $this->conn->query("UPDATE medicines SET stock = stock - " . intval($qty) . " WHERE id = " . intval($id));
    }

    public function count() {
        return $this->conn->query("SELECT COUNT(*) c FROM medicines")->fetch_assoc()['c'];
    }
}
