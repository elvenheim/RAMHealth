<?php
require_once('admin_connect.php');

$user_ids = $_POST['employee_id'];

foreach($user_ids as $user_id) {

    // Get user data before deleting
    $sql = "SELECT u.*, ul.employee_fullname, ul.employee_password, r.role_type ul.employee_email, 
            ul.employee_create_at
        FROM user u
        JOIN user_list ul ON u.employee_id = ul.employee_id
        JOIN role_type r ON FIND_IN_SET(r.role_id, u.user_role) > 0
        WHERE u.employee_id = ?";
    $stmt = mysqli_prepare($con, $select_query);
    mysqli_stmt_bind_param($stmt, 'i', $employee_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    mysqli_stmt_bind_result($stmt, $user_fullname, $user_email, $user_password, $user_role, $user_create_at);

    if (mysqli_stmt_fetch($stmt)) {
        // Insert deleted user data into deleted_users table
        $insert_query = "INSERT INTO deleted_users (user_id, user_fullname, user_email, user_password, 
                        user_role, user_create_at, user_delete_at) 
                        VALUES (?, ?, ?, ?, ?, ?, NOW())";
        $stmt2 = mysqli_prepare($con, $insert_query);
        mysqli_stmt_bind_param($stmt2, 'isssis', $user_id, $user_fullname, $user_email, $user_password, $user_role, $user_create_at);
        mysqli_stmt_execute($stmt2);

        // Delete user from user table
        $delete_query = "DELETE FROM user WHERE employee_id = ?";
        $stmt3 = mysqli_prepare($con, $delete_query);
        mysqli_stmt_bind_param($stmt3, 'i', $user_id);
        mysqli_stmt_execute($stmt3);

        if (mysqli_stmt_affected_rows($stmt3) > 0) {
            // Delete related data from user_list table
            $delete_query2 = "DELETE FROM user_list WHERE employee_id = ?";
            $stmt4 = mysqli_prepare($con, $delete_query2);
            mysqli_stmt_bind_param($stmt4, 'i', $user_id);
            mysqli_stmt_execute($stmt4);

            echo '<script type="text/javascript">alert("User(s) have been deleted successfully.");
            window.location.href="admin.php"</script>';
            exit;
        } else {
            echo "Error deleting user: " . mysqli_error($con);
        }
    } else {
        echo "Error getting user data: " . mysqli_error($con);
    }
}
?>