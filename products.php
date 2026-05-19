<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}
require '../includes/db.php';

// Handle Delete
if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    $stmt->execute([$_GET['delete']]);
    header("Location: products.php");
    exit;
}

// Handle Add/Edit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $desc = $_POST['description'];
    $cat = $_POST['category_id'];
    $stock = $_POST['stock_quantity'];
    $image = $_POST['image'];

    if (isset($_POST['id']) && !empty($_POST['id'])) {
        $stmt = $pdo->prepare("UPDATE products SET name=?, price=?, description=?, category_id=?, stock_quantity=?, image=? WHERE id=?");
        $stmt->execute([$name, $price, $desc, $cat, $stock, $image, $_POST['id']]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO products (name, price, description, category_id, stock_quantity, image) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$name, $price, $desc, $cat, $stock, $image]);
    }
    header("Location: products.php");
    exit;
}

$products = $pdo->query("SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id")->fetchAll();
$categories = $pdo->query("SELECT * FROM categories")->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <a href="dashboard.php" class="btn btn-secondary mb-3">Back to Dashboard</a>
    <h2>Manage Products</h2>
    
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Add / Edit Product</h5>
            <form method="POST">
                <input type="hidden" name="id" id="prod_id">
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <input type="text" name="name" id="prod_name" class="form-control" placeholder="Product Name" required>
                    </div>
                    <div class="col-md-6 mb-2">
                        <input type="number" step="0.01" name="price" id="prod_price" class="form-control" placeholder="Price" required>
                    </div>
                    <div class="col-md-6 mb-2">
                        <select name="category_id" id="prod_cat" class="form-control" required>
                            <option value="">Select Category</option>
                            <?php foreach($categories as $cat): ?>
                                <option value="<?php echo $cat['id']; ?>"><?php echo $cat['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6 mb-2">
                        <input type="number" name="stock_quantity" id="prod_stock" class="form-control" placeholder="Stock Quantity" required>
                    </div>
                    <div class="col-md-12 mb-2">
                        <input type="text" name="image" id="prod_image" class="form-control" placeholder="Image URL">
                    </div>
                    <div class="col-md-12 mb-2">
                        <textarea name="description" id="prod_desc" class="form-control" placeholder="Description"></textarea>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Save Product</button>
            </form>
        </div>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Price</th>
                <th>Category</th>
                <th>Stock</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($products as $p): ?>
                <tr>
                    <td><?php echo $p['id']; ?></td>
                    <td><?php echo $p['name']; ?></td>
                    <td>$<?php echo $p['price']; ?></td>
                    <td><?php echo $p['category_name']; ?></td>
                    <td><?php echo $p['stock_quantity']; ?></td>
                    <td>
                        <button class="btn btn-sm btn-warning" onclick="editProduct(<?php echo htmlspecialchars(json_encode($p)); ?>)">Edit</button>
                        <a href="?delete=<?php echo $p['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
function editProduct(p) {
    document.getElementById('prod_id').value = p.id;
    document.getElementById('prod_name').value = p.name;
    document.getElementById('prod_price').value = p.price;
    document.getElementById('prod_cat').value = p.category_id;
    document.getElementById('prod_stock').value = p.stock_quantity;
    document.getElementById('prod_image').value = p.image;
    document.getElementById('prod_desc').value = p.description;
}
</script>
</body>
</html>
