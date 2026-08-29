<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <title>Manager Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php require 'views/partials/navbar.php'; ?>

<div class="container">
    <h2>Manager Dashboard</h2>
    <?php if (isset($_GET['stocked'])): ?><div class="alert alert-success">Stock updated!</div><?php endif; ?>

    <div class="stat-grid">
        <div class="stat-box"><h3>৳<?= number_format($salesDaily, 2) ?></h3><p>Today's Sales</p></div>
        <div class="stat-box"><h3>৳<?= number_format($salesMonthly, 2) ?></h3><p>This Month's Sales</p></div>
    </div>

    <div class="card">
        <h3>Add Stock (Medicine Procurement)</h3>
        <form action="index.php?route=manager/dashboard" method="POST" style="display:flex;gap:10px;">
            <select name="medicine_id" style="margin-bottom:0;">
                <?php $medicines->data_seek(0); while ($m = $medicines->fetch_assoc()): ?>
                    <option value="<?= $m['id'] ?>"><?= htmlspecialchars($m['name']) ?> (stock: <?= $m['stock'] ?>)</option>
                <?php endwhile; ?>
            </select>
            <input type="number" name="qty" placeholder="Quantity" style="margin-bottom:0;width:120px;" required>
            <button type="submit" name="add_stock">Add Stock</button>
        </form>
    </div>

    <div class="card">
        <h3>Pending Orders (Approve/Reject)</h3>
        <table>
            <tr><th>#</th><th>Customer</th><th>Total</th><th>Action</th></tr>
            <?php while ($o = $pending->fetch_assoc()): ?>
            <tr>
                <td>#<?= $o['id'] ?></td>
                <td><?= htmlspecialchars($o['user_name']) ?></td>
                <td>৳<?= number_format($o['total_amount'], 2) ?></td>
                <td>
                    <form action="index.php?route=manager/dashboard" method="POST" style="display:inline-block;">
                        <input type="hidden" name="order_id" value="<?= $o['id'] ?>">
                        <input type="hidden" name="status" value="approved">
                        <button type="submit" name="order_action">Approve</button>
                    </form>
                    <form action="index.php?route=manager/dashboard" method="POST" style="display:inline-block;">
                        <input type="hidden" name="order_id" value="<?= $o['id'] ?>">
                        <input type="hidden" name="status" value="rejected">
                        <button type="submit" name="order_action" class="btn-danger">Reject</button>
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</div>
</body>
</html>
