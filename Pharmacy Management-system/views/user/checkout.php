<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php require 'views/partials/navbar.php'; ?>

<div class="container">
    <h2>Checkout</h2>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-error">
            <?php foreach ($errors as $error): ?>
                <p><?= htmlspecialchars($error) ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="card">
        <h3>Order Summary</h3>
        <table>
            <?php foreach ($rows as $r): ?>
            <tr><td><?= htmlspecialchars($r['name']) ?> x<?= $r['quantity'] ?></td><td>৳<?= number_format($r['subtotal'], 2) ?></td></tr>
            <?php endforeach; ?>
            <tr><th>Total</th><th>৳<?= number_format($total, 2) ?></th></tr>
        </table>
    </div>

    <div class="card">
        <form action="index.php?route=order/checkout" method="POST">
            <textarea name="address" placeholder="Delivery Address" rows="3" required><?= htmlspecialchars($_POST['address'] ?? '') ?></textarea>
            <select name="payment_method" required>
                <option value="cod">Cash On Delivery</option>
                <option value="card">Card</option>
                <option value="mobile_banking">Mobile Banking</option>
            </select>
            <button type="submit">Place Order</button>
        </form>
    </div>
</div>
</body>
</html>
