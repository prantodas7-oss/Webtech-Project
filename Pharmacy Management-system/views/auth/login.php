<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <title>Login - Pharmacy System</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php require 'views/partials/navbar.php'; ?>

<div class="form-box">
    <h2>Login</h2>

    <?php if (isset($_GET['registered'])): ?>
        <div class="alert alert-success">Registration successful. Please login.</div>
    <?php endif; ?>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-error">
            <?php foreach ($errors as $error): ?>
                <p><?= htmlspecialchars($error) ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form action="index.php?route=auth/login" method="POST">
        <input type="email" name="email" placeholder="Email" value="<?= htmlspecialchars($_COOKIE['last_email'] ?? '') ?>" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>

    <p style="margin-top:14px;text-align:center;">No account? <a href="index.php?route=auth/register">Register</a></p>
</div>
</body>
</html>
