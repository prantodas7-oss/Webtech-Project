<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <title>Manage Users</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php require 'views/partials/navbar.php'; ?>

<div class="container">
    <h2>All Users</h2>
    <table>
        <tr><th>Name</th><th>Email</th><th>Role</th><th>Status</th><th>Action</th></tr>
        <?php while ($u = $users->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($u['name']) ?></td>
            <td><?= htmlspecialchars($u['email']) ?></td>
            <td>
                <form action="index.php?route=admin/users" method="POST" style="display:flex;gap:6px;">
                    <input type="hidden" name="user_id" value="<?= $u['id'] ?>">
                    <select name="role" style="margin-bottom:0;">
                        <?php foreach (['user', 'admin', 'manager', 'deliveryman'] as $r): ?>
                            <option value="<?= $r ?>" <?= $u['role'] == $r ? 'selected' : '' ?>><?= $r ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit" name="role_change">Save</button>
                </form>
            </td>
            <td><?= $u['status'] ?></td>
            <td><a class="btn" href="index.php?route=admin/users&toggle=<?= $u['id'] ?>">Toggle Status</a></td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>
</body>
</html>
