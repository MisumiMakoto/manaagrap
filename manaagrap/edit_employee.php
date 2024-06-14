<?php
include 'db.php';
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $employee_id = $_GET['id'];
    $sql = "SELECT * FROM employees WHERE employee_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $employee_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $employee = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $employee_id = $_POST['employee_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $department_name = $_POST['department_name'];
    $role_name = $_POST['role_name'];

    $sql = "UPDATE employees SET first_name=?, last_name=?, email=?, phone=?, department_name=?, role_name=? WHERE employee_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssssssi', $first_name, $last_name, $email, $phone, $department_name, $role_name, $employee_id);

    if ($stmt->execute()) {
        header('Location: index.php');
    } else {
        echo 'Error: ' . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Employee</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container my-5">
        <h1 class="text-center mb-4">Edit Employee</h1>
        <form method="POST" action="edit_employee.php">
            <input type="hidden" name="employee_id" value="<?php echo $employee['employee_id']; ?>">
            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo $employee['first_name']; ?>" required>
            </div>
            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo $employee['last_name']; ?>">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $employee['email']; ?>" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $employee['phone']; ?>">
            </div>
                        <div class="form-group">
                            <label for="department_name">Department</label>
                            <select class="form-control" id="department_name" name="department_name">
                                <option value="">Select Department</option> <?php
                                                                            $sql = "SELECT * FROM departments";
                                                                            $result = $conn->query($sql);
                                                                            if ($result->num_rows > 0) {
                                                                                while ($row = $result->fetch_assoc()) {
                                                                                    echo "<option value='" . $row["department_id"] . "'>" . $row["department_name"] . "</option>";
                                                                                }
                                                                            }
                                                                            ?>
                            </select>
                            <span class="text-muted">OR</span>
                            <input type="text" class="form-control mt-1" id="custom_department" name="custom_department" placeholder="Enter custom department">
                        </div>
                        <div class="form-group">
                            <label for="role_name">Role</label>
                            <select class="form-control" id="role_name" name="role_name">
                                <option value="">Select Role</option> <?php
                                                                        $sql = "SELECT * FROM roles";
                                                                        $result = $conn->query($sql);
                                                                        if ($result->num_rows > 0) {
                                                                            while ($row = $result->fetch_assoc()) {
                                                                                echo "<option value='" . $row["role_id"] . "'>" . $row["role_name"] . "</option>";
                                                                            }
                                                                        }
                                                                        ?>
                            </select>
                            <span class="text-muted">OR</span>
                            <input type="text" class="form-control mt-1" id="custom_role" name="custom_role" placeholder="Enter custom role">
                        </div>
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>