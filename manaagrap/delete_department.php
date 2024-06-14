<?php
include 'db.php';
session_start();

if (!isset($_SESSION['username'])) {
  header('Location: index.php');
  exit();
}

if (isset($_GET['id'])) {
  $department_id = $_GET['id'];

  $sql = "DELETE FROM departments WHERE department_id=?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('i', $department_id);

  if ($stmt->execute()) {
    header('Location: index.php'); // Redirect to a confirmation page or previous list after successful deletion
  } else {
    echo 'Error: ' . $conn->error;
  }
}
?>
