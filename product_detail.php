<?php
require 'includes/db.php';
require 'includes/header.php';

$id = $_GET['id'] ?? 0;
$stmt = $pdo->prepare("SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE p.id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch();

if (!$product) {
    echo "<h2>Product not found</h2>";
    require 'includes/footer.php';
    exit;
}
?>

<div class="row">
    <div class="col-md-6">
        <img src="<?php echo $product['image'] ?: 'https://via.placeholder.com/500'; ?>" class="img-fluid" alt="<?php echo $product['name']; ?>">
    </div>
    <div class="col-md-6">
        <h2><?php echo $product['name']; ?></h2>
        <p class="text-muted">Category: <?php echo $product['category_name']; ?></p>
        <h3 class="text-primary">$<?php echo $product['price']; ?></h3>
        <p><?php echo $product['description']; ?></p>
        <p>Stock: <?php echo $product['stock_quantity']; ?></p>
        <button class="btn btn-success add-to-cart" data-id="<?php echo $product['id']; ?>">Add to Cart</button>
    </div>
</div>

<?php require 'includes/footer.php'; ?>
