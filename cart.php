<?php
require 'includes/db.php';
require 'includes/header.php';

$cart = $_SESSION['cart'] ?? [];
$products = [];
$total = 0;

if (!empty($cart)) {
    $ids = implode(',', array_keys($cart));
    $stmt = $pdo->query("SELECT * FROM products WHERE id IN ($ids)");
    $products = $stmt->fetchAll();
}
?>

<h2>Shopping Cart</h2>
<?php if (empty($products)): ?>
    <p>Your cart is empty.</p>
<?php else: ?>
    <table class="table">
        <thead>
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Subtotal</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): 
                $qty = $cart[$product['id']];
                $subtotal = $product['price'] * $qty;
                $total += $subtotal;
            ?>
                <tr>
                    <td><?php echo $product['name']; ?></td>
                    <td>$<?php echo $product['price']; ?></td>
                    <td>
                        <form action="cart_action.php" method="POST" class="d-inline">
                            <input type="hidden" name="action" value="update">
                            <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                            <input type="number" name="qty" value="<?php echo $qty; ?>" min="1" class="form-control d-inline w-25">
                            <button type="submit" class="btn btn-sm btn-secondary">Update</button>
                        </form>
                    </td>
                    <td>$<?php echo $subtotal; ?></td>
                    <td>
                        <form action="cart_action.php" method="POST">
                            <input type="hidden" name="action" value="remove">
                            <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                            <button type="submit" class="btn btn-sm btn-danger">Remove</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3" class="text-end">Total:</th>
                <th>$<?php echo $total; ?></th>
                <th></th>
            </tr>
        </tfoot>
    </table>
    <a href="checkout.php" class="btn btn-primary">Proceed to Checkout</a>
<?php endif; ?>

<?php require 'includes/footer.php'; ?>
