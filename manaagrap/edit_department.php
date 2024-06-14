<?php
include 'db.php';
session_start();

if (!isset($_SESSION['username'])) {
  header('Location: index.php');
  exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
  $department_id = $_GET['id'];
  $sql = "SELECT * FROM departments WHERE department_id=?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('i', $department_id);
  $stmt->execute();
  $result = $stmt->get_result();
  $department = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $department_id = $_POST['department_id'];
  $department_name = $_POST['department_name'];

  $sql = "UPDATE departments SET department_name=? WHERE department_id=?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('si', $department_name, $department_id);

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
  <title>Edit Department</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
  <div class="container my-5">
    <h1 class="text-center mb-4">Edit Department</h1>
        <form method="POST" action="edit_employee.php">
            <div class="form-group">
                <label for="department_name">Department Name</label>
                <input type="text" class="form-control" id="department_name" name="department_name" value="<?php echo $department['department_name']; ?>" required>
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
