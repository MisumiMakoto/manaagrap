<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['csvFile'])) {
    $file = $_FILES['csvFile']['tmp_name'];
    $handle = fopen($file, "r");

    if ($handle !== FALSE) {
        // Skip the first row if it contains headers
        fgetcsv($handle, 1000, ",");

        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $employee_id = $data[0];
            $first_name = $data[1];
            $last_name = $data[2];
            $email = $data[3];
            $phone = $data[4];
            $department_id = $data[5];
            $role_id = $data[6];

            $sql = "INSERT INTO employees (employee_id, first_name, last_name, email, phone, department_id, role_id) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('sssssii', $employee_id, $first_name, $last_name, $email, $phone, $department_id, $role_id);

            if (!$stmt->execute()) {
                echo 'Error: ' . $conn->error;
            }

            $stmt->close();
        }

        fclose($handle);
        header('Location: index.php');
    } else {
        echo 'Error opening the file.';
    }
} else {
    echo 'No file uploaded or invalid file.';
}
$conn->close();
?>