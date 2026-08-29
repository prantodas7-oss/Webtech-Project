<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <title>My Cart</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php require 'views/partials/navbar.php'; ?>

<div class="container">
    <h2>My Cart</h2>
    <table>
        <tr><th>Medicine</th><th>Price</th><th>Quantity</th><th>Subtotal</th><th>Action</th></tr>
        <?php foreach ($rows as $r): ?>
        <tr>
            <td><?= htmlspecialchars($r['name']) ?></td>
            <td>৳<?= number_format($r['price'], 2) ?></td>
            <td>
                <form action="index.php?route=cart/update" method="POST" style="display:flex;gap:6px;">
                    <input type="hidden" name="cart_id" value="<?= $r['cart_id'] ?>">
                    <input type="number" name="quantity" value="<?= $r['quantity'] ?>" min="1" max="<?= $r['stock'] ?>" style="width:70px;margin-bottom:0;">
                    <button type="submit">Update</button>
                </form>
            </td>
            <td>৳<?= number_format($r['subtotal'], 2) ?></td>
            <td><a class="btn btn-danger" href="index.php?route=cart/remove&id=<?= $r['cart_id'] ?>">Remove</a></td>
        </tr>
        <?php endforeach; ?>
    </table>

    <div class="card" style="margin-top:20px;">
        <h3>Total: ৳<?= number_format($total, 2) ?></h3>
        <?php if (count($rows) > 0): ?>
            <a class="btn" href="index.php?route=order/checkout" style="margin-top:10px;">Proceed to Checkout</a>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
