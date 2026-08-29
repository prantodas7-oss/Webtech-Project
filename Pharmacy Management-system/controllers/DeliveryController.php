<?php
require_once 'controllers/BaseController.php';
require_once 'models/OrderModel.php';

class DeliveryController extends BaseController {

    public function dashboard() {
        $this->requireRole('deliveryman');
        $deliverymanId = $_SESSION['user_id'];
        $orderModel = new OrderModel();

        if (isset($_POST['assign'])) {
            $orderModel->assignDeliveryman(intval($_POST['order_id']), $deliverymanId);
            $this->redirect('index.php?route=delivery/dashboard');
        }

        if (isset($_POST['update_status'])) {
            $orderModel->updateStatusByDeliveryman(intval($_POST['order_id']), $deliverymanId, $_POST['status']);
            $this->redirect('index.php?route=delivery/dashboard');
        }

        $this->view('delivery/dashboard', [
            'available' => $orderModel->getByStatus('approved'),
            'myDeliveries' => $orderModel->getByDeliveryman($deliverymanId, 'out_for_delivery'),
        ]);
    }
}
