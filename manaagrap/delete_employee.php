<?php
include 'db.php';
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}

if (isset($_GET['id'])) {
    $employee_id = $_GET['id'];

    $sql = "DELETE FROM employees WHERE employee_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $employee_id);

    if ($stmt->execute()) {
        header('Location: index.php');
    } else {
        echo 'Error: ' . $conn->error;
    }
}
?>