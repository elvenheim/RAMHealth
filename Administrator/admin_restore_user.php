<?php
    require_once('admin_connect.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Disable foreign key checks
        mysqli_query($con, "SET FOREIGN_KEY_CHECKS = 0");

        $deleted_user_id = $_POST['deleted_employee_id'];

        // Get user data before deleting
        $select_query = "SELECT * FROM deleted_users WHERE deleted_employee_id = ?";
        $stmt = mysqli_prepare($con, $select_query);
        mysqli_stmt_bind_param($stmt, 'i', $deleted_user_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);

        // Insert deleted user data into user_list table
        $insert_query = "INSERT INTO user_list (employee_id, employee_fullname, employee_email, 
        employee_password, employee_create_at) 
        VALUES (?, ?, ?, ?, ?)";
        $stmt2 = mysqli_prepare($con, $insert_query);
        mysqli_stmt_bind_param($stmt2, 'issss', $row['deleted_employee_id'], $row['deleted_employee_fullname'], $row['deleted_employee_email'], 
                                $row['deleted_employee_password'], $row['deleted_employee_create_at']);
        mysqli_stmt_execute($stmt2);

        // Delete related data from deleted_users table
        $delete_query2 = "DELETE FROM deleted_users WHERE deleted_employee_id = ?";
        $stmt4 = mysqli_prepare($con, $delete_query2);
        mysqli_stmt_bind_param($stmt4, 'i', $deleted_user_id);
        mysqli_stmt_execute($stmt4);
        
        // Enable foreign key checks
        mysqli_query($con, "SET FOREIGN_KEY_CHECKS = 1");
    
        if (mysqli_stmt_affected_rows($stmt2) > 0) {
            echo 'User has been restored successfully.';
        } else {
            echo "Error restoring user: " . mysqli_error($con);
        } 
    }
?>
