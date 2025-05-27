<?php
include 'inc/db.php';
$search = $_GET['search'] ?? '';
$min = $_GET['min_price'] ?? 0;
$max = $_GET['max_price'] ?? 100000000;

$sql = "SELECT * FROM products WHERE 1=1";
if (!empty($search)) {
  $search = $conn->real_escape_string($search);
  $sql .= " AND name LIKE '%$search%'";
}
$sql .= " AND price BETWEEN $min AND $max";
$res = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
  <title>Gadget Store</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="p-6 bg-gray-100">
  <form method="get" class="flex flex-col sm:flex-row gap-4 items-center mb-6">
    <input type="text" name="search" placeholder="Cari produk..." value="<?= $_GET['search'] ?? '' ?>" class="w-full sm:w-1/3 p-2 border rounded" />
    <input type="number" name="min_price" placeholder="Min Harga" value="<?= $_GET['min_price'] ?? '' ?>" class="w-full sm:w-1/4 p-2 border rounded" />
    <input type="number" name="max_price" placeholder="Max Harga" value="<?= $_GET['max_price'] ?? '' ?>" class="w-full sm:w-1/4 p-2 border rounded" />
    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Filter</button>
  </form>
  <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <?php while ($row = $res->fetch_assoc()): ?>
      <div class="bg-white p-4 rounded shadow">
        <h2 class="text-lg font-bold mb-2"><?= $row['name'] ?></h2>
        <p>Rp <?= number_format($row['price'], 0, ',', '.') ?></p>
        <a href="#" class="text-blue-600">Detail</a>
      </div>
    <?php endwhile; ?>
  </div>
</body>
</html>
