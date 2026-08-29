<?php
require_once 'controllers/BaseController.php';
require_once 'models/UserModel.php';

class AuthController extends BaseController {

    public function login() {
        $errors = $_SESSION['errors'] ?? [];
        unset($_SESSION['errors']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            if (empty($email)) {
                $errors[] = "Email is required.";
            }
            if (empty($password)) {
                $errors[] = "Password is required.";
            }

            if (empty($errors)) {
                $userModel = new UserModel();
                $user = $userModel->findByEmail($email);

                if (!$user) {
                    $errors[] = "No account found with this email.";
                } elseif ($user['status'] === 'inactive') {
                    $errors[] = "Your account has been deactivated.";
                } elseif (!password_verify($password, $user['password'])) {
                    $errors[] = "Incorrect password.";
                }
            }

            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                $this->redirect('index.php?route=auth/login');
            }

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['role'] = $user['role'];

            // Cookie: remember last used email for 7 days
            setcookie('last_email', $email, time() + (7 * 24 * 3600), "/");

            $this->redirect('index.php?route=home/dashboard');
        }

        $this->view('auth/login', ['errors' => $errors]);
    }

    public function register() {
        $errors = $_SESSION['errors'] ?? [];
        $old = $_SESSION['old'] ?? [];
        unset($_SESSION['errors'], $_SESSION['old']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirm = $_POST['confirm_password'] ?? '';

            if (empty($name)) {
                $errors[] = "Name is required.";
            }

            if (empty($email)) {
                $errors[] = "Email is required.";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Invalid email address.";
            }

            if (empty($password)) {
                $errors[] = "Password is required.";
            } elseif (strlen($password) < 8) {
                $errors[] = "Password must be at least 8 characters.";
            } elseif ($password !== $confirm) {
                $errors[] = "Password and Confirm Password did not match.";
            }

            $userModel = new UserModel();

            if (empty($errors) && $userModel->findByEmail($email)) {
                $errors[] = "This email is already registered.";
            }

            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                $_SESSION['old'] = ['name' => $name, 'email' => $email];
                $this->redirect('index.php?route=auth/register');
            }

            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $userModel->create($name, $email, $hashed);

            $this->redirect('index.php?route=auth/login&registered=1');
        }

        $this->view('auth/register', ['errors' => $errors, 'old' => $old]);
    }

    public function logout() {
        session_destroy();
        $this->redirect('index.php?route=auth/login');
    }
}
