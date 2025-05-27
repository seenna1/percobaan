<?php
header('Content-Type: application/json');
include '../inc/db.php';
$data = json_decode(file_get_contents("php://input"), true);
$name = $data['name'];
$price = $data['price'];
$conn->query("INSERT INTO products (name, price) VALUES ('$name', $price)");
echo json_encode(['status' => 'created']);
?>
