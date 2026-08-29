<?php
require_once 'controllers/BaseController.php';
require_once 'models/CartModel.php';

class CartController extends BaseController {

    public function index() {
        $this->requireRole('user');
        $cartModel = new CartModel();
        $items = $cartModel->getItems($_SESSION['user_id']);

        $rows = [];
        $total = 0;
        while ($r = $items->fetch_assoc()) {
            $r['subtotal'] = $r['price'] * $r['quantity'];
            $total += $r['subtotal'];
            $rows[] = $r;
        }

        $this->view('user/cart', ['rows' => $rows, 'total' => $total]);
    }

    public function add() {
        $this->requireRole('user');
        $medicineId = intval($_GET['id'] ?? 0);

        $cartModel = new CartModel();
        $cartModel->add($_SESSION['user_id'], $medicineId);

        $this->redirect('index.php?route=home/index&added=1');
    }

    public function update() {
        $this->requireRole('user');
        $cartId = intval($_POST['cart_id'] ?? 0);
        $qty = max(1, intval($_POST['quantity'] ?? 1));

        $cartModel = new CartModel();
        $cartModel->updateQuantity($cartId, $_SESSION['user_id'], $qty);

        $this->redirect('index.php?route=cart/index');
    }

    public function remove() {
        $this->requireRole('user');
        $cartId = intval($_GET['id'] ?? 0);

        $cartModel = new CartModel();
        $cartModel->remove($cartId, $_SESSION['user_id']);

        $this->redirect('index.php?route=cart/index');
    }
}
