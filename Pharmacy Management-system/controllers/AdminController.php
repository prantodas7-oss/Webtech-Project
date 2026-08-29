<?php
require_once 'controllers/BaseController.php';
require_once 'models/MedicineModel.php';
require_once 'models/CategoryModel.php';
require_once 'models/UserModel.php';
require_once 'models/OrderModel.php';

class AdminController extends BaseController {

    public function dashboard() {
        $this->requireRole('admin');

        $userModel = new UserModel();
        $medicineModel = new MedicineModel();
        $orderModel = new OrderModel();

        $stats = [
            'totalUsers' => $userModel->countByRole('user'),
            'totalMedicines' => $medicineModel->count(),
            'totalOrders' => $orderModel->count(),
            'totalSales' => $orderModel->totalSales(),
        ];

        $this->view('admin/dashboard', ['stats' => $stats]);
    }

    public function medicines() {
        $this->requireRole('admin');

        $medicineModel = new MedicineModel();
        $categoryModel = new CategoryModel();
        $errors = [];
        $editing = null;

        if (isset($_GET['delete'])) {
            $medicineModel->delete(intval($_GET['delete']));
            $this->redirect('index.php?route=admin/medicines');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => trim($_POST['name'] ?? ''),
                'category_id' => intval($_POST['category_id'] ?? 0),
                'description' => trim($_POST['description'] ?? ''),
                'price' => floatval($_POST['price'] ?? 0),
                'stock' => intval($_POST['stock'] ?? 0),
                'expiry_date' => $_POST['expiry_date'] ?? '',
                'image' => null,
            ];
            $editId = intval($_POST['edit_id'] ?? 0);

            if (empty($data['name'])) {
                $errors[] = "Medicine name is required.";
            }
            if ($data['category_id'] <= 0) {
                $errors[] = "Please select a category.";
            }
            if ($data['price'] <= 0) {
                $errors[] = "Price must be greater than 0.";
            }

            if (!empty($_FILES['image']['name'])) {
                $data['image'] = time() . '_' . basename($_FILES['image']['name']);
            }

            if (empty($errors)) {
                if (!empty($_FILES['image']['name'])) {
                    move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . '/../storage/uploads/' . $data['image']);
                }

                if ($editId > 0) {
                    $medicineModel->update($editId, $data);
                } else {
                    $medicineModel->create($data);
                }
                $this->redirect('index.php?route=admin/medicines');
            }
        }

        if (isset($_GET['edit'])) {
            $editing = $medicineModel->find(intval($_GET['edit']));
        }

        $this->view('admin/medicines', [
            'medicines' => $medicineModel->getAllWithCategory(),
            'categories' => $categoryModel->getAll(),
            'editing' => $editing,
            'errors' => $errors,
        ]);
    }

    public function categories() {
        $this->requireRole('admin');
        $categoryModel = new CategoryModel();

        if (isset($_GET['delete'])) {
            $categoryModel->delete(intval($_GET['delete']));
            $this->redirect('index.php?route=admin/categories');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            if (!empty($name)) {
                $categoryModel->create($name);
            }
            $this->redirect('index.php?route=admin/categories');
        }

        $this->view('admin/categories', ['categories' => $categoryModel->getAll()]);
    }

    public function users() {
        $this->requireRole('admin');
        $userModel = new UserModel();

        if (isset($_GET['toggle'])) {
            $userModel->toggleStatus(intval($_GET['toggle']));
            $this->redirect('index.php?route=admin/users');
        }

        if (isset($_POST['role_change'])) {
            $userModel->updateRole(intval($_POST['user_id']), $_POST['role']);
            $this->redirect('index.php?route=admin/users');
        }

        $this->view('admin/users', ['users' => $userModel->getAll()]);
    }

    public function orders() {
        $this->requireRole('admin');
        $orderModel = new OrderModel();

        if (isset($_POST['update_status'])) {
            $orderModel->updateStatus(intval($_POST['order_id']), $_POST['status']);
            $this->redirect('index.php?route=admin/orders');
        }

        $this->view('admin/orders', ['orders' => $orderModel->getAll()]);
    }
}
