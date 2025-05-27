<?php
$conn = new mysqli('localhost', 'root', '', 'gadget_store');
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);
?>
