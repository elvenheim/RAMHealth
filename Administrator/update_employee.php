<?php
    require_once('admin_connect.php');

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['employee_id'])) {
        $employeeId = $_POST['employee_id'];
        $newEmployeeName = $_POST['new_employee_name'];
        $newEmployeeEmail = $_POST['new_employee_email'];
        $newEmployeePassword = isset($_POST['new_employee_password']) ? $_POST['new_employee_password'] : '';
        $selectedRoles = isset($_POST['role_name']) ? $_POST['role_name'] : [];

        mysqli_query($con, "SET FOREIGN_KEY_CHECKS = 0");
        
        // Update the employee details in the database
        $updateQuery = "UPDATE user_list SET employee_fullname = '$newEmployeeName', employee_email = '$newEmployeeEmail', 
                        employee_password = '$newEmployeePassword' WHERE employee_id = '$employeeId'";
        $updateResult = mysqli_query($con, $updateQuery);

        if ($updateResult) {
            // Delete all existing role associations for the employee
            $deleteRolesQuery = "DELETE FROM user WHERE employee_id = '$employeeId'";
            mysqli_query($con, $deleteRolesQuery);

            // Insert the selected roles for the employee
            foreach ($selectedRoles as $roleId) {
                $insertRoleQuery = "INSERT INTO user (employee_id, user_role) VALUES ('$employeeId', '$roleId')";
                mysqli_query($con, $insertRoleQuery);
            }

            mysqli_query($con, "SET FOREIGN_KEY_CHECKS = 1");
            echo '<script type="text/javascript">alert("User updated successfully.");
            window.location.href="admin.php"</script>';
        } else {
            echo 'Error updating employee details.';
        }
    } else {
        echo 'Invalid request.';
    }
?>
