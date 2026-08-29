<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php require 'views/partials/navbar.php'; ?>

<div class="container">
    <h2>Admin Dashboard</h2>
    <div class="stat-grid">
        <div class="stat-box"><h3><?= $stats['totalUsers'] ?></h3><p>Total Users</p></div>
        <div class="stat-box"><h3><?= $stats['totalMedicines'] ?></h3><p>Total Medicines</p></div>
        <div class="stat-box"><h3><?= $stats['totalOrders'] ?></h3><p>Total Orders</p></div>
        <div class="stat-box"><h3>৳<?= number_format($stats['totalSales'], 2) ?></h3><p>Total Sales</p></div>
    </div>

    <div class="card">
        <h3>Quick Links</h3>
        <p style="margin-top:10px;">
            <a class="btn" href="index.php?route=admin/medicines">Manage Medicines</a>
            <a class="btn" href="index.php?route=admin/categories">Manage Categories</a>
            <a class="btn" href="index.php?route=admin/users">Manage Users</a>
            <a class="btn" href="index.php?route=admin/orders">View Orders</a>
        </p>
    </div>
</div>
</body>
</html>
