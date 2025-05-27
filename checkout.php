<?php
session_start();
include 'inc/db.php';

if (!isset($_SESSION['user'])) {
  header("Location: login.php");
  exit;
}

$user_id = $_SESSION['user']['id'];
$total = 0;

if (!empty($_SESSION['cart'])) {
  foreach ($_SESSION['cart'] as $id => $qty) {
    $res = $conn->query("SELECT * FROM products WHERE id=$id");
    $prod = $res->fetch_assoc();
    $total += $prod['price'] * $qty;
  }
}

if (isset($_POST['pay'])) {
  $method = $_POST['method'];
  $conn->query("INSERT INTO orders (user_id, total, payment_method) VALUES ($user_id, $total, '$method')");
  $_SESSION['cart'] = [];
  header("Location: success.php");
}
?>
<!DOCTYPE html>
<html>
<head><title>Checkout</title><script src="https://cdn.tailwindcss.com"></script></head>
<body class="p-6 bg-gray-100">
  <div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-4">Pembayaran</h1>
    <p class="mb-2">Total: <strong>Rp <?= number_format($total, 0, ',', '.') ?></strong></p>
    <form method="post">
      <label class="block mb-2 font-semibold">Pilih metode pembayaran:</label>
      <label><input type="radio" name="method" value="DANA" required> DANA</label><br>
      <label><input type="radio" name="method" value="GoPay" required> GoPay</label><br>
      <label><input type="radio" name="method" value="OVO" required> OVO</label><br>
      <button type="submit" name="pay" class="mt-4 bg-green-600 text-white px-4 py-2 rounded">Bayar</button>
    </form>
  </div>
</body>
</html>
