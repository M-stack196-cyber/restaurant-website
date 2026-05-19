<?php
require 'includes/db.php';
require 'includes/header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$cart = $_SESSION['cart'] ?? [];
if (empty($cart)) {
    header("Location: index.php");
    exit;
}

$ids = implode(',', array_keys($cart));
$stmt = $pdo->query("SELECT * FROM products WHERE id IN ($ids)");
$products = $stmt->fetchAll();
$total = 0;
foreach ($products as $product) {
    $total += $product['price'] * $cart[$product['id']];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $pdo->beginTransaction();
        
        $stmt = $pdo->prepare("INSERT INTO orders (user_id, total_bill) VALUES (?, ?)");
        $stmt->execute([$_SESSION['user_id'], $total]);
        $order_id = $pdo->lastInsertId();

        $stmt = $pdo->prepare("INSERT INTO order_details (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
        foreach ($products as $product) {
            $stmt->execute([$order_id, $product['id'], $cart[$product['id']], $product['price']]);
            
            // Update stock
            $updateStock = $pdo->prepare("UPDATE products SET stock_quantity = stock_quantity - ? WHERE id = ?");
            $updateStock->execute([$cart[$product['id']], $product['id']]);
        }

        $pdo->commit();
        unset($_SESSION['cart']);
        echo "<div class='alert alert-success'>Order placed successfully! Order ID: $order_id</div>";
        echo "<a href='index.php' class='btn btn-primary'>Back to Home</a>";
        require 'includes/footer.php';
        exit;
    } catch (Exception $e) {
        $pdo->rollBack();
        $error = "Order failed: " . $e->getMessage();
    }
}
?>

<h2>Checkout</h2>
<p>Total Amount: <strong>$<?php echo $total; ?></strong></p>
<form method="POST">
    <button type="submit" class="btn btn-success">Place Order</button>
</form>

<?php require 'includes/footer.php'; ?>
