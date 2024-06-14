<?php
include 'db.php';
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $department_id = $_POST['department_id'];
    $role_id = $_POST['role_id'];

    $sql = "INSERT INTO employees (first_name, last_name, email, phone, department_id, role_id) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssssii', $first_name, $last_name, $email, $phone, $department_id, $role_id);

    if ($stmt->execute()) {
        header('Location: index.php');
    } else {
        echo 'Error: ' . $conn->error;
    }
}
?>