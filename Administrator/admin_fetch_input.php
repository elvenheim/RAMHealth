<?php
    require_once('admin_connect.php');

    $user_id = $_POST['user_id'];
    $user_role = $_POST['role_name'];
    $user_fullname = $_POST['user_fullname'];
    $user_email = $_POST['user_email'];
    $user_password = $_POST['user_password'];
    $user_created_at = date('Y-m-d');

    // Check if user_id already exists in the database
    $select_query = "SELECT user_id FROM user WHERE user_id = ?";
    $stmt = mysqli_prepare($con, $select_query);
    mysqli_stmt_bind_param($stmt, 'i', $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if(mysqli_num_rows($result) > 0) {
        echo '<script type="text/javascript">alert("User already exists");
            window.location.href="admin.php"</script>';
        exit;
    }

    $insert_query = "INSERT INTO user (user_id, user_role, user_fullname, 
                    user_email, user_password, user_create_at) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($con, $insert_query);
    mysqli_stmt_bind_param($stmt, 'isssss', $user_id, $user_role, 
        $user_fullname, $user_email, $user_password, $user_created_at);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) > 0) {
        echo '<script type="text/javascript">alert("User added successfully");
            window.location.href="admin.php"</script>';
        exit;
    } else {
        echo '<script type="text/javascript">alert("Error adding user...");
            window.location.href="admin.php"</script>';
        exit;
    }

?>
