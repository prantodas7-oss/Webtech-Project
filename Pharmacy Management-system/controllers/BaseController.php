<?php
class BaseController {

    protected function requireLogin() {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('index.php?route=auth/login');
        }
    }

    protected function requireRole($role) {
        $this->requireLogin();
        if ($_SESSION['role'] !== $role) {
            $this->redirect('index.php?route=home/dashboard');
        }
    }

    protected function redirect($url) {
        header("Location: $url");
        exit;
    }

    protected function view($viewPath, $data = []) {
        extract($data);
        require 'views/' . $viewPath . '.php';
    }
}
