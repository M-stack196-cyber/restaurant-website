<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}
require '../includes/db.php';

if (isset($_POST['update_status'])) {
    $stmt = $pdo->prepare("UPDATE orders SET status = ? WHERE id = ?");
    $stmt->execute([$_POST['status'], $_POST['order_id']]);
}

$orders = $pdo->query("SELECT o.*, u.username FROM orders o JOIN users u ON o.user_id = u.id ORDER BY o.created_at DESC")->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <a href="dashboard.php" class="btn btn-secondary mb-3">Back to Dashboard</a>
    <h2>Manage Orders</h2>
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>User</th>
                <th>Total Bill</th>
                <th>Status</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($orders as $o): ?>
                <tr>
                    <td><?php echo $o['id']; ?></td>
                    <td><?php echo $o['username']; ?></td>
                    <td>$<?php echo $o['total_bill']; ?></td>
                    <td><?php echo $o['status']; ?></td>
                    <td><?php echo $o['created_at']; ?></td>
                    <td>
                        <form method="POST" class="d-inline">
                            <input type="hidden" name="order_id" value="<?php echo $o['id']; ?>">
                            <select name="status" class="form-select form-select-sm d-inline w-auto">
                                <option value="Pending" <?php echo $o['status'] == 'Pending' ? 'selected' : ''; ?>>Pending</option>
                                <option value="Shipped" <?php echo $o['status'] == 'Shipped' ? 'selected' : ''; ?>>Shipped</option>
                                <option value="Delivered" <?php echo $o['status'] == 'Delivered' ? 'selected' : ''; ?>>Delivered</option>
                            </select>
                            <button type="submit" name="update_status" class="btn btn-sm btn-primary">Update</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
