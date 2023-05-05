<?php
    require_once('admin_connect.php');

    $user_id = $_POST['user_id'];

    // Get user data before deleting
    $select_query = "SELECT user_fullname, user_email, user_password, user_role, user_create_at FROM user WHERE user_id = ?";
    $stmt = mysqli_prepare($con, $select_query);
    mysqli_stmt_bind_param($stmt, 'i', $user_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    mysqli_stmt_bind_result($stmt, $user_fullname, $user_email, $user_password, $user_role, $user_create_at);

    if (mysqli_stmt_fetch($stmt)) {
        // Insert deleted user data into deleted_users table
        $insert_query = "INSERT INTO deleted_users (user_id, user_fullname, user_email, user_password, user_role, user_create_at, user_delete_at) VALUES (?, ?, ?, ?, ?, ?, NOW())";
        $stmt2 = mysqli_prepare($con, $insert_query);
        mysqli_stmt_bind_param($stmt2, 'isssis', $user_id, $user_fullname, $user_email, $user_password, $user_role, $user_create_at);
        mysqli_stmt_execute($stmt2);

        // Delete user from user table
        $delete_query = "DELETE FROM user WHERE user_id = ?";
        $stmt3 = mysqli_prepare($con, $delete_query);
        mysqli_stmt_bind_param($stmt3, 'i', $user_id);
        mysqli_stmt_execute($stmt3);

        if (mysqli_stmt_affected_rows($stmt3) > 0) {
            echo '<script type="text/javascript">alert("User has been deleted successfully.");
            window.location.href="admin.php"</script>';
            exit;
        } else {
            echo "Error deleting user: " . mysqli_error($con);
        }
    } else {
        echo "Error getting user data: " . mysqli_error($con);
    }
?>
