<?php
include('config.php'); // your DB connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $rating = $_POST['rating'];
  $message = $_POST['message'];

  $sql = "INSERT INTO feedback (name, email, rating, message) VALUES ('$name', '$email', '$rating', '$message')";
  if (mysqli_query($con, $sql)) {
    header("Location: index.php?success=1");
  } else {
    header("Location: feedback.php?error=1");
  }
}
?>
