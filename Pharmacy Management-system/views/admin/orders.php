<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <title>All Orders</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php require 'views/partials/navbar.php'; ?>

<div class="container">
    <h2>All Orders</h2>
    <table>
        <tr><th>#</th><th>Customer</th><th>Total</th><th>Payment</th><th>Status</th><th>Update</th></tr>
        <?php while ($o = $orders->fetch_assoc()): ?>
        <tr>
            <td>#<?= $o['id'] ?></td>
            <td><?= htmlspecialchars($o['user_name']) ?></td>
            <td>৳<?= number_format($o['total_amount'], 2) ?></td>
            <td><?= $o['payment_method'] ?></td>
            <td><?= $o['status'] ?></td>
            <td>
                <form action="index.php?route=admin/orders" method="POST" style="display:flex;gap:6px;">
                    <input type="hidden" name="order_id" value="<?= $o['id'] ?>">
                    <select name="status" style="margin-bottom:0;">
                        <?php foreach (['pending', 'approved', 'rejected', 'out_for_delivery', 'delivered'] as $s): ?>
                            <option value="<?= $s ?>" <?= $o['status'] == $s ? 'selected' : '' ?>><?= $s ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit" name="update_status">Save</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>
</body>
</html>
