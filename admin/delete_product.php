<?php
include '../inc/db.php';
$id = $_GET['id'] ?? 0;
$conn->query("DELETE FROM products WHERE id=$id");
header("Location: dashboard.php");
?>