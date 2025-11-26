<?php
session_start();
include('config.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $email = trim($_POST['email']);
  $password = trim($_POST['password']);

  $stmt = $con->prepare("SELECT * FROM signup WHERE email = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    if (password_verify($password, $user['password'])) {
      $_SESSION['email'] = $user['email'];
      header("Location: index.php");
      exit();
    } else {
      header("Location: login.php?error=Invalid password");
      exit();
    }
  } else {
    header("Location: login.php?error=No account found");
    exit();
  }
}
?>
