<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RAM Health</title> 
    <link rel="stylesheet" href="../Administrator/Admin Design/admin_content_edit_user.css">
    <link rel="shortcut icon" href="../favicons/favicon.ico"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.3.0/css/all.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function cancelEdit() {
            window.location.href = 'admin.php'; // Replace with the desired page URL to redirect the user
        }
    </script>
</head>
<body>

    <?php
        require_once('admin_connect.php');
        
        // Check if the form is submitted and the employee_id parameter is present
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['employee_id'])) {
            $employeeId = $_POST['employee_id'];
            
            // Retrieve the employee details from the database based on the employee ID
            $query = "SELECT * FROM user_list WHERE employee_id = '$employeeId'";
            $result = mysqli_query($con, $query);
            
            // Check if the employee exists
            if (mysqli_num_rows($result) > 0) {
                $employee = mysqli_fetch_assoc($result);
                
                // Retrieve all roles from the database
                $roleIdsQuery = "SELECT role_id, role_name FROM role_type";
                $roleIdsResult = mysqli_query($con, $roleIdsQuery);
                
                // Retrieve the roles associated with the user
                $userRolesQuery = "SELECT user_role FROM user WHERE employee_id = '$employeeId'";
                $userRolesResult = mysqli_query($con, $userRolesQuery);
                
                // Store the role IDs associated with the user in an array
                $userRoleIds = array();
                while ($row = mysqli_fetch_assoc($userRolesResult)) {
                    $userRoleIds[] = $row['user_role'];
                }
                
                // Display the form to edit the employee details
                echo '<div class="form-container">';
                echo '<form method="post" action="update_employee.php">'; // Replace with your update page URL
                
                echo '<div class="form-title">';
                echo 'Edit User';
                echo '</div>';

                echo '<div style="display: none;">';
                echo 'Employee ID: <input type="text" name="employee_id" value="' . $employee['employee_id'] . '" readonly>';
                echo '</div>';

                echo '<label for="new_employee_name">User Full Name:</label>';
                echo '<input type="text" name="new_employee_name" value="' . $employee['employee_fullname'] . '">';
                
                echo '<label for="new_employee_email">User Email:</label>';
                echo '<input type="text" name="new_employee_email" value="' . $employee['employee_email'] . '">';
                
                echo '<label for="new_employee_password">User Password:</label>';
                echo '<input type="text" name="new_employee_password" value="' . $employee['employee_password'] . '">';
                
                echo '<label for="role_name">Assign Roles:</label>';
                echo '<div class="checkbox-list">';
                
                while ($row = mysqli_fetch_assoc($roleIdsResult)) {
                    $isChecked = in_array($row['role_id'], $userRoleIds) ? 'checked' : '';
                    echo '<label>';
                    echo '<input type="checkbox" name="role_name[]" value="' . $row['role_id'] . '" ' . $isChecked . '> ' . $row['role_name'];
                    echo '</label>';
                }
                
                echo '</div>';
                
                // Add other fields you want to edit
                
                echo '<div class="form-buttons">';
                echo '<input type="submit" value="Update">';
                echo '<button type="button" onclick="cancelEdit()">Cancel</button>';
                echo '</div>';

                echo '</form>';
                echo '</div>';
            } else {
                echo 'Employee not found.';
            }
        } else {
            echo 'Invalid request.';
        }
    ?>

</body>
</html>
