<?php
include 'inc/db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $pass = $_POST['password'];
  $conn->query("INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$pass')");
  echo "Registrasi berhasil";
}
?>
<form method="post">
  <input name="name" placeholder="Nama Lengkap" required><br>
  <input name="email" placeholder="Email" required><br>
  <input name="password" type="password" placeholder="Password" required><br>
  <button type="submit">Register</button>
</form>
<a href="login.php">Sudah punya akun? Login di sini</a>
<?php
$conn->close();
?>