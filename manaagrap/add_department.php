<?php
include 'db.php';
session_start();

if (!isset($_SESSION['username'])) {
  header('Location: index.php');
  exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $department_name = $_POST['department_name'];

  $sql = "INSERT INTO departments (department_name) VALUES (?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('s', $department_name);

  if ($stmt->execute()) {
    header('Location: index.php');
  } else {
    echo 'Error: ' . $conn->error;
  }
}
?>