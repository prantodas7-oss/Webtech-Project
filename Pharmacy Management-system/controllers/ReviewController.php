<?php
require_once 'controllers/BaseController.php';
require_once 'models/ReviewModel.php';

class ReviewController extends BaseController {

    public function store() {
        $this->requireRole('user');

        $medicineId = intval($_POST['medicine_id'] ?? 0);
        $rating = intval($_POST['rating'] ?? 5);
        $comment = trim($_POST['comment'] ?? '');

        $reviewModel = new ReviewModel();
        $reviewModel->create($_SESSION['user_id'], $medicineId, $rating, $comment);

        $this->redirect('index.php?route=order/history&reviewed=1');
    }
}
