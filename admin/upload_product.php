<?php
include '../inc/db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['name'];
  $price = $_POST['price'];
  $kategori = $_POST['kategori'];

  $imageName = $_FILES['image']['name'];
  $tmp = $_FILES['image']['tmp_name'];
  $target = "../uploads/" . basename($imageName);
  move_uploaded_file($tmp, $target);

  $conn->query("INSERT INTO products (name, price, kategori, image) VALUES ('$name', $price, '$kategori', '$imageName')");
  echo "Produk berhasil ditambahkan.";
}
?>
<form method="post" enctype="multipart/form-data">
  <input name="name" placeholder="Nama Produk" required><br>
  <input name="price" placeholder="Harga" type="number" required><br>
  <input name="kategori" placeholder="Kategori"><br>
  <input type="file" name="image" required><br>
  <button type="submit">Upload</button>
</form>
<a href="index.php">Kembali ke Dashboard</a>