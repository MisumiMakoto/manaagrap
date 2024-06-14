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
    $department_name = $_POST['department_name'];
    $role_name = $_POST['role_name'];

    $sql = "INSERT INTO employees (first_name, last_name, email, phone, department_name, role_name) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssssss', $first_name, $last_name, $email, $phone, $department_name, $role_name);

    if ($stmt->execute()) {
        header('Location: index.php');
    } else {
        echo 'Error: ' . $conn->error;
    }
}
?>