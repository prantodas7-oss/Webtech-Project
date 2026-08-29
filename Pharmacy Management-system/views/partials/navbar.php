<div class="navbar">
    <div class="brand">💊 Pharmacy System</div>
    <div>
        <a href="index.php?route=home/index">Home</a>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="index.php?route=home/dashboard">Dashboard</a>
            <?php if ($_SESSION['role'] === 'user'): ?>
                <a href="index.php?route=cart/index">Cart</a>
                <a href="index.php?route=wishlist/index">Wishlist</a>
            <?php endif; ?>
            <a href="index.php?route=auth/logout">Logout (<?= htmlspecialchars($_SESSION['name']) ?>)</a>
        <?php else: ?>
            <a href="index.php?route=auth/login">Login</a>
            <a href="index.php?route=auth/register">Register</a>
        <?php endif; ?>
    </div>
</div>
