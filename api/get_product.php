<?php header('Content-Type: application/json'); echo json_encode(['id' => 1]); ?>
<?php
header('Content-Type: application/json');
include '../inc/db.php';
$id = $_GET['id'] ?? 0;
$res = $conn->query("SELECT * FROM products WHERE id=$id");
echo json_encode($res->fetch_assoc());
?>
