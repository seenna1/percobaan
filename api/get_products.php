<?php header('Content-Type: application/json'); echo json_encode(['status' => 'ok']); ?>
<?php
header('Content-Type: application/json');
include '../inc/db.php';
$res = $conn->query("SELECT * FROM products");
$products = [];
while ($row = $res->fetch_assoc()) {
  $products[] = $row;
}
echo json_encode($products);
?>
