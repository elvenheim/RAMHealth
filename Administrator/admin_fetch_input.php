<?php
    require_once('admin_connect.php');

    $user_id = $_POST['employee_id'];
    $user_fullname = $_POST['employee_fullname'];
    $user_email = $_POST['employee_email'];
    $user_password = $_POST['employee_password'];
    $user_created_at = date('Y-m-d');
    $roles = $_POST['role_name'];

    // Check if user_id already exists in the database
    $select_query = "SELECT employee_id FROM user_list WHERE employee_id = ?";
    $stmt = mysqli_prepare($con, $select_query);
    mysqli_stmt_bind_param($stmt, 'i', $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if(mysqli_num_rows($result) > 0) {
        echo '<script type="text/javascript">alert("User already exists");
            window.location.href="admin.php"</script>';
        exit;
    }

    // disable foreign key check
    mysqli_query($con, "SET foreign_key_checks = 0");

    // insert data into user_list table
    $insert_user_list_query = "INSERT INTO user_list (employee_id, employee_fullname, employee_email, employee_password, employee_create_at) VALUES (?, ?, ?, ?, ?)";
    $stmt_user_list = mysqli_prepare($con, $insert_user_list_query);
    mysqli_stmt_bind_param($stmt_user_list, 'issss', $user_id, $user_fullname, $user_email, $user_password, $user_created_at);
    mysqli_stmt_execute($stmt_user_list);

    // insert data into user table
    $insert_user_query = "INSERT INTO user (employee_id, user_role) VALUES (?, ?)";
    $stmt_user = mysqli_prepare($con, $insert_user_query);
    foreach ($roles as $role) {
        mysqli_stmt_bind_param($stmt_user, 'is', $user_id, $role);
        mysqli_stmt_execute($stmt_user);
    }

    // re-enable foreign key check
    mysqli_query($con, "SET foreign_key_checks = 1");

    mysqli_commit($con);

    echo '<script type="text/javascript">alert("User added successfully");
        window.location.href="admin.php"</script>';
    exit;
?>
