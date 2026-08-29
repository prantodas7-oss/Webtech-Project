<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <title>Manage Categories</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php require 'views/partials/navbar.php'; ?>

<div class="container">
    <h2>Add Category</h2>
    <div class="card">
        <form action="index.php?route=admin/categories" method="POST">
            <input type="text" name="name" placeholder="Category Name" required>
            <button type="submit">Add Category</button>
        </form>
    </div>

    <h2>All Categories</h2>
    <table>
        <tr><th>Name</th><th>Action</th></tr>
        <?php while ($c = $categories->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($c['name']) ?></td>
            <td><a class="btn btn-danger" href="index.php?route=admin/categories&delete=<?= $c['id'] ?>" onclick="return confirm('Delete this category?')">Delete</a></td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>
</body>
</html>
