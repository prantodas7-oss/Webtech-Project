<?php
require_once 'controllers/BaseController.php';
require_once 'models/MedicineModel.php';

class HomeController extends BaseController {

    public function index() {
        $medicineModel = new MedicineModel();
        $search = $_GET['search'] ?? '';
        $medicines = $medicineModel->getAll($search);
        $this->view('home/index', ['medicines' => $medicines, 'search' => $search]);
    }

    public function dashboard() {
        $this->requireLogin();

        switch ($_SESSION['role']) {
            case 'admin':
                $this->redirect('index.php?route=admin/dashboard');
                break;
            case 'manager':
                $this->redirect('index.php?route=manager/dashboard');
                break;
            case 'deliveryman':
                $this->redirect('index.php?route=delivery/dashboard');
                break;
            default:
                $this->redirect('index.php?route=user/dashboard');
        }
    }
}
