<?php
include 'inc/db.php';
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
  die("Akses ditolak!");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['name'];
  $price = $_POST['price'];
  $kategori = $_POST['kategori'];

  $imageName = $_FILES['image']['name'];
  $tmp = $_FILES['image']['tmp_name'];
  $target = "uploads/" . basename($imageName);
  move_uploaded_file($tmp, $target);

  $conn->query("INSERT INTO products (name, price, kategori, image) VALUES ('$name', $price, '$kategori', '$imageName')");
  header("Location: dashboard.php");
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Tambah Produk</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="p-6 bg-gray-100">
  <div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-xl font-bold mb-4">Tambah Produk Baru</h1>
    <form method="post" enctype="multipart/form-data" class="space-y-4">
      <input name="name" placeholder="Nama Produk" required class="w-full border p-2 rounded"><br>
      <input name="price" placeholder="Harga" type="number" required class="w-full border p-2 rounded"><br>
      <input name="kategori" placeholder="Kategori" class="w-full border p-2 rounded"><br>
      <input type="file" name="image" required class="w-full"><br>
      <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Tambah</button>
    </form>
    <a href="dashboard.php" class="inline-block mt-4 text-blue-500">← Kembali ke Dashboard</a>
  </div>
</body>
</html>
