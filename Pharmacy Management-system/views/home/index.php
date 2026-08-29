<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <title>Pharmacy System - Home</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php require 'views/partials/navbar.php'; ?>

<div class="container">
    <?php if (isset($_GET['added'])): ?><div class="alert alert-success">Added to cart!</div><?php endif; ?>
    <?php if (isset($_GET['wishlisted'])): ?><div class="alert alert-success">Added to wishlist!</div><?php endif; ?>

    <form action="index.php" method="GET" style="margin-bottom:20px;display:flex;gap:10px;">
        <input type="hidden" name="route" value="home/index">
        <input type="text" name="search" placeholder="Search medicine..." value="<?= htmlspecialchars($search) ?>" style="margin-bottom:0;">
        <button type="submit">Search</button>
    </form>

    <div class="grid">
        <?php while ($m = $medicines->fetch_assoc()): ?>
            <div class="product-card">
                <img src="<?= $m['image'] ? 'storage/uploads/' . htmlspecialchars($m['image']) : 'https://via.placeholder.com/220x140?text=Medicine' ?>" alt="">
                <h4><?= htmlspecialchars($m['name']) ?></h4>
                <div class="price">৳<?= number_format($m['price'], 2) ?></div>
                <a class="btn" href="index.php?route=cart/add&id=<?= $m['id'] ?>">Add to Cart</a>
                <a class="btn" style="background:#c9a227;" href="index.php?route=wishlist/add&id=<?= $m['id'] ?>">♥ Wishlist</a>
            </div>
        <?php endwhile; ?>
    </div>
</div>
</body>
</html>
