<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <title>Deliveryman Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php require 'views/partials/navbar.php'; ?>

<div class="container">
    <h2>Deliveryman Dashboard</h2>

    <div class="card">
        <h3>Orders Ready For Pickup</h3>
        <table>
            <tr><th>#</th><th>Customer</th><th>Address</th><th>Action</th></tr>
            <?php while ($o = $available->fetch_assoc()): ?>
            <tr>
                <td>#<?= $o['id'] ?></td>
                <td><?= htmlspecialchars($o['user_name']) ?></td>
                <td><?= htmlspecialchars($o['address']) ?></td>
                <td>
                    <form action="index.php?route=delivery/dashboard" method="POST">
                        <input type="hidden" name="order_id" value="<?= $o['id'] ?>">
                        <button type="submit" name="assign">Pick Up</button>
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <div class="card">
        <h3>My Current Deliveries</h3>
        <table>
            <tr><th>#</th><th>Customer</th><th>Address</th><th>Action</th></tr>
            <?php while ($o = $myDeliveries->fetch_assoc()): ?>
            <tr>
                <td>#<?= $o['id'] ?></td>
                <td><?= htmlspecialchars($o['user_name']) ?></td>
                <td><?= htmlspecialchars($o['address']) ?></td>
                <td>
                    <form action="index.php?route=delivery/dashboard" method="POST" style="display:flex;gap:6px;">
                        <input type="hidden" name="order_id" value="<?= $o['id'] ?>">
                        <input type="hidden" name="status" value="delivered">
                        <button type="submit" name="update_status">Mark Delivered</button>
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</div>
</body>
</html>
