<?php
session_start();
require 'includes/db.php';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$action = $_POST['action'] ?? '';

if ($action == 'add') {
    $id = $_POST['id'];
    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]++;
    } else {
        $_SESSION['cart'][$id] = 1;
    }
    echo json_encode(['status' => 'success', 'count' => array_sum($_SESSION['cart'])]);
} elseif ($action == 'remove') {
    $id = $_POST['id'];
    unset($_SESSION['cart'][$id]);
    header("Location: cart.php");
} elseif ($action == 'update') {
    $id = $_POST['id'];
    $qty = $_POST['qty'];
    if ($qty <= 0) {
        unset($_SESSION['cart'][$id]);
    } else {
        $_SESSION['cart'][$id] = $qty;
    }
    header("Location: cart.php");
}
?>
