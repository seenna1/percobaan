<?php
session_start();
include 'inc/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = intval($_POST['product_id']);
    $qty = intval($_POST['quantity']);
    if ($qty > 0) {
        $_SESSION['cart'][$product_id] = $qty;
    } else {
        unset($_SESSION['cart'][$product_id]);
    }
    header("Location: cart.php");
    exit;
}

echo "<h2>Keranjang Belanja</h2>";
if (!empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $id => $qty) {
        $id = intval($id);
        $result = $conn->query("SELECT * FROM products WHERE id = $id");
        if ($result && $p = $result->fetch_assoc()) {
            $total = $p['price'] * $qty;
            echo htmlspecialchars($p['name']) . " - Qty: $qty - Rp " . number_format($total, 0, ',', '.') . "<br>";
        }
    }
} else {
    echo "Keranjang kosong.";
}
?>
