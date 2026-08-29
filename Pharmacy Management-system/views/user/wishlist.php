<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <title>My Wishlist</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php require 'views/partials/navbar.php'; ?>

<div class="container">
    <h2>My Wishlist</h2>
    <?php if (isset($_GET['moved'])): ?><div class="alert alert-success">Moved to cart!</div><?php endif; ?>

    <div class="grid">
        <?php while ($w = $items->fetch_assoc()): ?>
            <div class="product-card">
                <img src="<?= $w['image'] ? 'storage/uploads/' . htmlspecialchars($w['image']) : 'https://via.placeholder.com/220x140?text=Medicine' ?>" alt="">
                <h4><?= htmlspecialchars($w['name']) ?></h4>
                <div class="price">৳<?= number_format($w['price'], 2) ?></div>
                <a class="btn" href="index.php?route=wishlist/moveToCart&id=<?= $w['wishlist_id'] ?>">Move to Cart</a>
                <a class="btn btn-danger" href="index.php?route=wishlist/remove&id=<?= $w['wishlist_id'] ?>">Remove</a>
            </div>
        <?php endwhile; ?>
    </div>
</div>
</body>
</html>
