<?php
require_once 'controllers/BaseController.php';
require_once 'models/CartModel.php';
require_once 'models/OrderModel.php';
require_once 'models/MedicineModel.php';

class OrderController extends BaseController {

    public function checkout() {
        $this->requireRole('user');
        $userId = $_SESSION['user_id'];

        $cartModel = new CartModel();
        $items = $cartModel->getItems($userId);

        $rows = [];
        $total = 0;
        while ($r = $items->fetch_assoc()) {
            $r['subtotal'] = $r['price'] * $r['quantity'];
            $total += $r['subtotal'];
            $rows[] = $r;
        }

        if (empty($rows)) {
            $this->redirect('index.php?route=cart/index');
        }

        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $address = trim($_POST['address'] ?? '');
            $paymentMethod = $_POST['payment_method'] ?? '';

            if (empty($address)) {
                $errors[] = "Delivery address is required.";
            }
            if (empty($paymentMethod)) {
                $errors[] = "Please select a payment method.";
            }

            if (empty($errors)) {
                $orderModel = new OrderModel();
                $medicineModel = new MedicineModel();

                $orderId = $orderModel->create($userId, $total, $address, $paymentMethod);

                foreach ($rows as $r) {
                    $orderModel->addItem($orderId, $r['medicine_id'], $r['quantity'], $r['price']);
                    $medicineModel->reduceStock($r['medicine_id'], $r['quantity']);
                }

                $orderModel->addPayment($orderId, $total, $paymentMethod);
                $cartModel->clear($userId);

                $this->redirect('index.php?route=order/history&placed=1');
            }
        }

        $this->view('user/checkout', ['rows' => $rows, 'total' => $total, 'errors' => $errors]);
    }

    public function history() {
        $this->requireRole('user');
        $orderModel = new OrderModel();
        $orders = $orderModel->getByUser($_SESSION['user_id']);
        $this->view('user/orders', ['orders' => $orders, 'orderModel' => $orderModel]);
    }
}
