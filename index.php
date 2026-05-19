<?php
require 'includes/db.php';
require 'includes/header.php';

$stmt = $pdo->query("SELECT * FROM products");
$products = $stmt->fetchAll();
?>

<h1 class="mb-4">Our Products</h1>
<div class="row">
    <?php foreach ($products as $product): ?>
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <img src="<?php echo $product['image'] ?: 'https://via.placeholder.com/300'; ?>" class="card-img-top" alt="<?php echo $product['name']; ?>">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $product['name']; ?></h5>
                    <p class="card-text text-muted"><?php echo substr($product['description'], 0, 100); ?>...</p>
                    <p class="card-text"><strong>$<?php echo $product['price']; ?></strong></p>
                    <a href="product_detail.php?id=<?php echo $product['id']; ?>" class="btn btn-primary">View Details</a>
                    <button class="btn btn-success add-to-cart" data-id="<?php echo $product['id']; ?>">Add to Cart</button>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php require 'includes/footer.php'; ?>
