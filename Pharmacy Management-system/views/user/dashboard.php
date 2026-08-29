<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <title>My Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php require 'views/partials/navbar.php'; ?>

<div class="container">
    <h2>Welcome, <?= htmlspecialchars($_SESSION['name']) ?></h2>
    <p style="margin:14px 0;">
        <a class="btn" href="index.php?route=home/index">Browse Medicines</a>
        <a class="btn" href="index.php?route=cart/index">My Cart</a>
        <a class="btn" href="index.php?route=order/history">My Orders</a>
    </p>

    <h3>Recent Orders</h3>
    <table>
        <tr><th>#</th><th>Total</th><th>Status</th><th>Date</th></tr>
        <?php while ($o = $orders->fetch_assoc()): ?>
        <tr>
            <td>#<?= $o['id'] ?></td>
            <td>৳<?= number_format($o['total_amount'], 2) ?></td>
            <td><?= $o['status'] ?></td>
            <td><?= $o['created_at'] ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>
</body>
</html>
