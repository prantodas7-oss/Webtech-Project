<?php
require_once 'controllers/BaseController.php';
require_once 'models/MedicineModel.php';
require_once 'models/OrderModel.php';

class ManagerController extends BaseController {

    public function dashboard() {
        $this->requireRole('manager');

        $medicineModel = new MedicineModel();
        $orderModel = new OrderModel();

        if (isset($_POST['add_stock'])) {
            $medicineModel->addStock(intval($_POST['medicine_id']), intval($_POST['qty']));
            $this->redirect('index.php?route=manager/dashboard&stocked=1');
        }

        if (isset($_POST['order_action'])) {
            $orderModel->updateStatus(intval($_POST['order_id']), $_POST['status']);
            $this->redirect('index.php?route=manager/dashboard');
        }

        $this->view('manager/dashboard', [
            'medicines' => $medicineModel->getAll(),
            'pending' => $orderModel->getByStatus('pending'),
            'salesDaily' => $orderModel->totalSales("status='delivered' AND DATE(created_at)=CURDATE()"),
            'salesMonthly' => $orderModel->totalSales("status='delivered' AND MONTH(created_at)=MONTH(CURDATE())"),
        ]);
    }
}
