<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <title>Manage Medicines</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php require 'views/partials/navbar.php'; ?>

<div class="container">
    <h2><?= $editing ? 'Edit Medicine' : 'Add New Medicine' ?></h2>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-error">
            <?php foreach ($errors as $error): ?>
                <p><?= htmlspecialchars($error) ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="card">
        <form action="index.php?route=admin/medicines" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="edit_id" value="<?= $editing['id'] ?? 0 ?>">
            <input type="text" name="name" placeholder="Medicine Name" value="<?= htmlspecialchars($editing['name'] ?? '') ?>" required>

            <select name="category_id" required>
                <option value="">-- Select Category --</option>
                <?php $categories->data_seek(0); while ($c = $categories->fetch_assoc()): ?>
                    <option value="<?= $c['id'] ?>" <?= (isset($editing) && $editing['category_id'] == $c['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($c['name']) ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <textarea name="description" placeholder="Description" rows="3"><?= htmlspecialchars($editing['description'] ?? '') ?></textarea>
            <input type="number" step="0.01" name="price" placeholder="Price" value="<?= $editing['price'] ?? '' ?>" required>
            <input type="number" name="stock" placeholder="Stock Quantity" value="<?= $editing['stock'] ?? '' ?>" required>
            <input type="date" name="expiry_date" value="<?= $editing['expiry_date'] ?? '' ?>" required>
            <input type="file" name="image">
            <button type="submit"><?= $editing ? 'Update Medicine' : 'Add Medicine' ?></button>
            <?php if ($editing): ?><a class="btn btn-danger" href="index.php?route=admin/medicines">Cancel</a><?php endif; ?>
        </form>
    </div>

    <h2>All Medicines</h2>
    <table>
        <tr><th>Name</th><th>Category</th><th>Price</th><th>Stock</th><th>Expiry</th><th>Action</th></tr>
        <?php while ($m = $medicines->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($m['name']) ?></td>
            <td><?= htmlspecialchars($m['category_name'] ?? '-') ?></td>
            <td>৳<?= number_format($m['price'], 2) ?></td>
            <td><?= $m['stock'] ?></td>
            <td><?= $m['expiry_date'] ?></td>
            <td>
                <a class="btn" href="index.php?route=admin/medicines&edit=<?= $m['id'] ?>">Edit</a>
                <a class="btn btn-danger" href="index.php?route=admin/medicines&delete=<?= $m['id'] ?>" onclick="return confirm('Delete this medicine?')">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>
</body>
</html>
