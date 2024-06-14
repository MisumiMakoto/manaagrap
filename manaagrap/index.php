<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Management App</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container my-5">
        <h1 class="text-center mb-4">Manager App</h1>
        <?php
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION['username'])) {
            echo '<div class="text-right mb-4">
                    <span>Welcome, ' . htmlspecialchars($_SESSION['username']) . '!</span>
                    <a href="logout.php" class="btn btn-danger ml-2">Logout</a>
                  </div>';
        } else {
            echo '<div class="text-right mb-4">
                <button class="btn btn-primary" data-toggle="modal" data-target="#authModal">Login/Register</button>
              </div>';
        }
        ?>
        <ul class="nav nav-tabs mb-4">
            <li class="nav-item">
                <a class="nav-link active" href="#employees" data-toggle="tab">Employees</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#departments" data-toggle="tab">Departments</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="employees">
                <div class="mb-4">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#employeeModal">Add Employee</button>
                    <button class="btn btn-secondary" data-toggle="modal" data-target="#importModal">Import CSV</button>

                </div>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Department</th>
                            <th>Role</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Employee rows will be dynamically populated here -->
                        <?php
                        include 'db.php';
                        if (session_status() == PHP_SESSION_NONE) {
                            session_start();
                        }
                        if (isset($_SESSION['username'])) {
                            echo '<h1>Welcome, ' . $_SESSION['username'] . '!</h1>';
                            $sql = "SELECT * FROM employees";
                            $result = $conn->query($sql);

                            while ($row = $result->fetch_assoc()) {
                                echo '<tr>
                                    <td>' . $row['employee_id'] . '</td>
                                    <td>' . $row['first_name'] . '</td>
                                    <td>' . $row['last_name'] . '</td>
                                    <td>' . $row['email'] . '</td>
                                    <td>' . $row['phone'] . '</td>
                                    <td>' . $row['department_name'] . '</td>
                                    <td>' . $row['role_name'] . '</td>
                                    <td>
                                        <a href="edit_employee.php?id=' . $row['employee_id'] . '">Edit</a>
                                        <a href="delete_employee.php?id=' . $row['employee_id'] . '">Delete</a>
                                    </td>
                                </tr>';
                            }
                        } else {
                            echo '<p>Please <a href="#" data-toggle="modal" data-target="#loginModal">login</a> to see employee details.</p>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="departments">
                <div class="mb-4">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#departmentModal">Add Department</button>
                </div>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>/tba</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Department rows will be dynamically populated here -->
                        // this is a dinamic table fetch *testing*
                        <?php

                        $sql = "SELECT * FROM departments";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            echo "<table class='table table-striped'>"; // Bootstrap styles here as well
                            echo "<thead>";
                            echo "<tr>";
                            echo "<th>ID</th>";
                            echo "<th>Department Name</th>";
                            echo "</tr>";
                            echo "</thead>";
                            echo "<tbody>";

                            while ($row = $result->fetch_assoc()) {
                                echo '<tr>
                                     <td>' . $row["department_id"] . '</td>
                                     <td>' . $row["department_name"] . '</td>
                                     <td>
                                        <a href="edit_department.php?id=' . $row['department_id'] . '">Edit</a>
                                        <a href="delete_department.php?id=' . $row['department_id'] . '">Delete</a>
                                     </td>
                                     </tr>';
                            }

                            echo "</tbody>";
                            echo "</table>";
                        } else {
                            echo "No departments found";
                        }
                        ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Import CSV Modal -->
    <div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importModalLabel">Import Employees from CSV</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="importForm" method="POST" action="import_csv.php" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="csvFile">CSV File</label>
                            <input type="file" class="form-control" id="csvFile" name="csvFile" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="importSubmitBtn">Import</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Login Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModalLabel">Login</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="loginForm" method="POST" action="login.php">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="loginBtn">Login</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Authentication Modal -->
    <div class="modal fade" id="authModal" tabindex="-1" role="dialog" aria-labelledby="authModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="authModalLabel">Login / Register</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-tabs" id="authTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="login-tab" data-toggle="tab" href="#login" role="tab" aria-controls="login" aria-selected="true">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="register-tab" data-toggle="tab" href="#register" role="tab" aria-controls="register" aria-selected="false">Register</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="authTabContent">
                        <div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="login-tab">

                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            </form>
                            <div class="text-right">
                                <button type="button" class="btn btn-link" data-toggle="modal" data-target="#forgotPasswordModal">Forgot Password?</button>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="register" role="tabpanel" aria-labelledby="register-tab">
                            <form id="registerForm" method="POST" action="register.php" class="mt-3">
                                <div class="form-group">
                                    <label for="register_username">Username</label>
                                    <input type="text" class="form-control" id="register_username" name="username" required>
                                </div>
                                <div class="form-group">
                                    <label for="register_password">Password</label>
                                    <input type="password" class="form-control" id="register_password" name="password" required>
                                </div>
                                <div class="form-group">
                                    <label for="register_password_confirm">Confirm Password</label>
                                    <input type="password" class="form-control" id="register_password_confirm" name="password_confirm" required>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="authSubmitBtn">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Forgot Password Modal -->
    <div class="modal fade" id="forgotPasswordModal" tabindex="-1" role="dialog" aria-labelledby="forgotPasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="forgotPasswordModalLabel">Forgot Password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="forgotPasswordForm" method="POST" action="forgot_password.php">
                        <div class="form-group">
                            <label for="forgot_email">Email</label>
                            <input type="email" class="form-control" id="forgot_email" name="email" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="forgotPasswordSubmitBtn">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Register Modal -->
    <div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="registerModalLabel">Register</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="registerForm" method="POST" action="register.php">
                        <div class="form-group">
                            <label for="register_username">Username</label>
                            <input type="text" class="form-control" id="register_username" name="username" required>
                        </div>
                        <div class="form-group">
                            <label for="register_password">Password</label>
                            <input type="password" class="form-control" id="register_password" name="password" required>
                        </div>
                        <div class="form-group">
                            <label for="register_confirm_password">Confirm Password</label>
                            <input type="password" class="form-control" id="register_confirm_password" name="confirm_password" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="registerBtn">Register</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Employee Modal -->
    <div class="modal fade" id="employeeModal" tabindex="-1" role="dialog" aria-labelledby="employeeModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="employeeModalLabel">Add/Edit Employee</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="employeeForm" method="POST" action="add_employee.php">
                        <div class="form-group">
                            <label for="first_name">First Name</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" required>
                        </div>
                        <div class="form-group">
                            <label for="last_name">Last Name</label>
                            <input type="text" class="form-control" id="last_name" name="last_name">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" class="form-control" id="phone" id="phone_input" name="phone">
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
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary" id="saveEmployeeBtn">Save</button>
                        </div>
                </div>
            </div>
        </div>

        <!-- Department Modal -->
        <div class="modal fade" id="departmentModal" tabindex="-1" role="dialog" aria-labelledby="departmentModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="departmentModalLabel">Add/Edit Department</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="departmentForm" method="POST" action="add_department.php">
                            <div class="form-group">
                                <label for="department_name">Name</label>
                                <input type="text" class="form-control" id="department_name" name="department_name" required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="saveDepartmentBtn">Save</button>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#authSubmitBtn').on('click', function() {
                    if ($('#authTab .active').attr('id') === 'login-tab') {
                        $('#loginForm').submit();
                    } else {
                        $('#registerForm').submit();
                    }
                });

                $('#forgotPasswordSubmitBtn').on('click', function() {
                    $('#forgotPasswordForm').submit();
                });

                $('#saveEmployeeBtn').click(function() {
                    $('#employeeForm').submit();
                });

                $('#saveDepartmentBtn').click(function() {
                    $('#departmentForm').submit();
                });

                $('#loginBtn').click(function() {
                    $('#loginForm').submit();
                });

                $('#registerBtn').click(function() {
                    $('#registerForm').submit();
                });

                $('#importSubmitBtn').on('click', function() {
                    $('#importForm').submit();
                });
            });
        </script>
</body>

</html>