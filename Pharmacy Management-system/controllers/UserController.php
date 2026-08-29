<?php
require_once 'controllers/BaseController.php';
require_once 'models/OrderModel.php';

class UserController extends BaseController {

    public function dashboard() {
        $this->requireRole('user');
        $orderModel = new OrderModel();
        $orders = $orderModel->getRecentByUser($_SESSION['user_id'], 5);
        $this->view('user/dashboard', ['orders' => $orders]);
    }
}
