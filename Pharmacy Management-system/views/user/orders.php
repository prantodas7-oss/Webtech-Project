<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <title>My Orders</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php require 'views/partials/navbar.php'; ?>

<div class="container">
    <h2>My Orders</h2>
    <?php if (isset($_GET['placed'])): ?><div class="alert alert-success">Order placed successfully!</div><?php endif; ?>
    <?php if (isset($_GET['reviewed'])): ?><div class="alert alert-success">Review submitted!</div><?php endif; ?>

    <?php while ($o = $orders->fetch_assoc()): ?>
        <div class="card">
            <h3>Order #<?= $o['id'] ?> - <?= $o['status'] ?></h3>
            <p>Total: ৳<?= number_format($o['total_amount'], 2) ?> | Payment: <?= $o['payment_method'] ?> | Date: <?= $o['created_at'] ?></p>

            <?php $items = $orderModel->getItemsForOrder($o['id']); ?>
            <table>
                <tr><th>Medicine</th><th>Qty</th><th>Price</th><?php if ($o['status'] === 'delivered'): ?><th>Review</th><?php endif; ?></tr>
                <?php while ($it = $items->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($it['name']) ?></td>
                    <td><?= $it['quantity'] ?></td>
                    <td>৳<?= number_format($it['price'], 2) ?></td>
                    <?php if ($o['status'] === 'delivered'): ?>
                    <td>
                        <form action="index.php?route=review/store" method="POST" style="display:flex;gap:6px;align-items:center;">
                            <input type="hidden" name="medicine_id" value="<?= $it['medicine_id'] ?>">
                            <select name="rating" style="margin-bottom:0;width:70px;">
                                <?php for ($i = 5; $i >= 1; $i--): ?><option value="<?= $i ?>"><?= $i ?>★</option><?php endfor; ?>
                            </select>
                            <input type="text" name="comment" placeholder="Comment" style="margin-bottom:0;">
                            <button type="submit">Send</button>
                        </form>
                    </td>
                    <?php endif; ?>
                </tr>
                <?php endwhile; ?>
            </table>
        </div>
    <?php endwhile; ?>
</div>
</body>
</html>
