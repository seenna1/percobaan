<?php
header('Content-Type: application/json');
include '../inc/db.php';
$id = $_GET['id'];
$conn->query("DELETE FROM products WHERE id=$id");
echo json_encode(['status' => 'deleted']);
?>
