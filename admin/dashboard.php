<?php
include 'inc/db.php';
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
  die("Akses ditolak!");
}

$res = $conn->query("SELECT * FROM products ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
  <title>Dashboard Admin</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="p-6 bg-gray-50">
  <div class="max-w-6xl mx-auto">
    <h1 class="text-2xl font-bold mb-6">Dashboard Admin</h1>
    <a href="add_product.php" class="inline-block bg-green-600 text-white px-4 py-2 rounded mb-4">+ Tambah Produk</a>
    <table class="w-full bg-white shadow rounded overflow-hidden text-sm">
      <thead class="bg-gray-200">
        <tr>
          <th class="text-left px-4 py-2">ID</th>
          <th class="text-left px-4 py-2">Nama</th>
          <th class="text-left px-4 py-2">Harga</th>
          <th class="text-left px-4 py-2">Kategori</th>
          <th class="text-left px-4 py-2">Gambar</th>
          <th class="text-left px-4 py-2">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $res->fetch_assoc()): ?>
          <tr class="border-t">
            <td class="px-4 py-2"><?= $row['id'] ?></td>
            <td class="px-4 py-2"><?= $row['name'] ?></td>
            <td class="px-4 py-2">Rp <?= number_format($row['price'], 0, ',', '.') ?></td>
            <td class="px-4 py-2"><?= $row['kategori'] ?></td>
            <td class="px-4 py-2">
              <?php if ($row['image']): ?>
                <img src="uploads/<?= $row['image'] ?>" width="50">
              <?php endif; ?>
            </td>
            <td class="px-4 py-2">
              <a href="edit_product.php?id=<?= $row['id'] ?>" class="text-blue-600">Edit</a> |
              <a href="delete_product.php?id=<?= $row['id'] ?>" class="text-red-600" onclick="return confirm('Hapus produk ini?')">Hapus</a>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
