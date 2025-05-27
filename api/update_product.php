<?php
header('Content-Type: application/json');
include '../inc/db.php';
$id = $_GET['id'];
$data = json_decode(file_get_contents("php://input"), true);
$name = $data['name'];
$price = $data['price'];
$conn->query("UPDATE products SET name='$name', price=$price WHERE id=$id");
echo json_encode(['status' => 'updated']);
?>
