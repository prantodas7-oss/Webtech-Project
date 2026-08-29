<?php
require_once 'controllers/BaseController.php';
require_once 'models/WishlistModel.php';
require_once 'models/CartModel.php';

class WishlistController extends BaseController {

    public function index() {
        $this->requireRole('user');
        $wishlistModel = new WishlistModel();
        $items = $wishlistModel->getItems($_SESSION['user_id']);
        $this->view('user/wishlist', ['items' => $items]);
    }

    public function add() {
        $this->requireRole('user');
        $medicineId = intval($_GET['id'] ?? 0);

        $wishlistModel = new WishlistModel();
        $wishlistModel->add($_SESSION['user_id'], $medicineId);

        $this->redirect('index.php?route=home/index&wishlisted=1');
    }

    public function remove() {
        $this->requireRole('user');
        $id = intval($_GET['id'] ?? 0);

        $wishlistModel = new WishlistModel();
        $wishlistModel->remove($id, $_SESSION['user_id']);

        $this->redirect('index.php?route=wishlist/index');
    }

    public function moveToCart() {
        $this->requireRole('user');
        $id = intval($_GET['id'] ?? 0);
        $userId = $_SESSION['user_id'];

        $wishlistModel = new WishlistModel();
        $item = $wishlistModel->find($id, $userId);

        if ($item) {
            $cartModel = new CartModel();
            $cartModel->add($userId, $item['medicine_id']);
            $wishlistModel->remove($id, $userId);
        }

        $this->redirect('index.php?route=wishlist/index&moved=1');
    }
}
