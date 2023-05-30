<?php
    require_once('admin_connect.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Disable foreign key checks
        mysqli_query($con, "SET FOREIGN_KEY_CHECKS = 0");

        $user_id = $_POST['employee_id'];

        // Get user data before deleting
        $select_query = "SELECT * FROM user_list WHERE employee_id = ?";
        $stmt = mysqli_prepare($con, $select_query);
        mysqli_stmt_bind_param($stmt, 'i', $user_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);

        // Insert deleted user data into deleted_users table
        $insert_query = "INSERT INTO deleted_users (deleted_employee_id, deleted_employee_fullname, deleted_employee_email, 
        deleted_employee_password, deleted_employee_create_at, employee_delete_at) 
        VALUES (?, ?, ?, ?, ?, NOW())";
        $stmt2 = mysqli_prepare($con, $insert_query);
        mysqli_stmt_bind_param($stmt2, 'issss', $row['employee_id'], $row['employee_fullname'], $row['employee_email'], $row['employee_password'], $row['employee_create_at']);
        mysqli_stmt_execute($stmt2);

        // Delete related data from user_list table
        $delete_query2 = "DELETE FROM user_list WHERE employee_id = ?";
        $stmt4 = mysqli_prepare($con, $delete_query2);
        mysqli_stmt_bind_param($stmt4, 'i', $user_id);
        mysqli_stmt_execute($stmt4);
        
        // Enable foreign key checks
        mysqli_query($con, "SET FOREIGN_KEY_CHECKS = 1");
    
        if (mysqli_stmt_affected_rows($stmt) > 0) {
            echo 'User has been deleted successfully.';
        } else {
            echo "Error deleting user: " . mysqli_error($con);
        } 
    }
?>
