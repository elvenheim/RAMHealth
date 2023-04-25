<?php
    session_name('my_session');
    session_start();

    $email = $_POST['email'];
    $password = $_POST['password'];

    require_once('admin_connect.php');

    // Check if the email and password are valid
    $sql = "SELECT user_id, user_role FROM user WHERE user_email = '$email' AND user_password = '$password'";
    $result = mysqli_query($conn, $sql);

    if ($row = mysqli_fetch_assoc($result)) {
        // Login successful, store user data in session
        $_SESSION['user_id'] = $row['user_id'];
        session_regenerate_id(); // Regenerate session ID to prevent session fixation attacks

        // Check if the user has admin privileges
        $role_id = $row['user_role'];
        $sql = "SELECT role_url FROM role_type WHERE role_id = '$role_id' AND role_name = 'admin'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            // Show admin content
        }
    }

    // Close database connection
    mysqli_close($conn);
?>
