<?php
    require_once('admin_connect.php');
    
    $user_id = $_POST['user_id'];
    
    $delete_query = "DELETE FROM user WHERE user_id = ?";
    $stmt = mysqli_prepare($con, $delete_query);
    mysqli_stmt_bind_param($stmt, 'i', $user_id);
    mysqli_stmt_execute($stmt);
    
    if (mysqli_stmt_affected_rows($stmt) > 0) {
        echo '<script type="text/javascript">alert("User has been deleted successfully.");
        window.location.href="admin.php"</script>';
        exit;
    } else {
        echo "Error deleting user: " . mysqli_error($con);
    }
?>
