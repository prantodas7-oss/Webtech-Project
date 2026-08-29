<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <title>Register - Pharmacy System</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php require 'views/partials/navbar.php'; ?>

<div class="form-box">
    <h2>Create Account</h2>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-error">
            <?php foreach ($errors as $error): ?>
                <p><?= htmlspecialchars($error) ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form action="index.php?route=auth/register" method="POST">
        <input type="text" name="name" placeholder="Full Name" value="<?= htmlspecialchars($old['name'] ?? '') ?>" required>
        <input type="email" name="email" placeholder="Email" value="<?= htmlspecialchars($old['email'] ?? '') ?>" required>
        <input type="password" name="password" placeholder="Password (min 8 chars)" required>
        <input type="password" name="confirm_password" placeholder="Confirm Password" required>
        <button type="submit">Register</button>
    </form>

    <p style="margin-top:14px;text-align:center;">Already have an account? <a href="index.php?route=auth/login">Login</a></p>
</div>
</body>
</html>
