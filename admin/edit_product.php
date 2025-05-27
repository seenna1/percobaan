<?php
include '../inc/db.php';
$id = $_GET['id'] ?? 0;
$res = $conn->query("SELECT * FROM products WHERE id=$id");
$product = $res->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['name'];
  $price = $_POST['price'];
  $conn->query("UPDATE products SET name='$name', price=$price WHERE id=$id");
  header("Location: dashboard.php");
}
?>
<form method="post">
  <input name="name" value="<?= $product['name'] ?>" required><br>
  <input name="price" value="<?= $product['price'] ?>" required type="number"><br>
  <button type="submit">Update</button>
</form>