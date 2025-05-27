<?php
session_start();

// Koneksi database langsung di sini
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'gadget_store_v2';

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
  die("Koneksi gagal: " . $conn->connect_error);
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = $_POST['email'];
  $pass = $_POST['password'];

  // Gunakan prepared statement untuk mencegah SQL injection
  $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
  $stmt->bind_param("ss", $email, $pass);
  $stmt->execute();
  $res = $stmt->get_result();

  if ($res->num_rows > 0) {
    $_SESSION['user'] = $res->fetch_assoc();
    header("Location: index.php");
    exit();
  } else {
    $error = "Login gagal";
  }
  $stmt->close();
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="p-6 bg-gray-100">
  <div class="max-w-md mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-4">Login</h1>
    <?php if (!empty($error)): ?>
      <div class="mb-4 text-red-600"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    <form method="post">
      <input name="email" placeholder="Email" required class="w-full p-2 border rounded mb-4"><br>
      <input name="password" placeholder="Password" type="password" required class="w-full p-2 border rounded mb-4"><br>
      <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Login</button>
    </form>
    <p class="mt-4">Belum punya akun? <a href="register.php" class="text-blue-600">Daftar di sini</a></p>
  </div>
</body>
</html>
<?php
$conn->close();
?>
