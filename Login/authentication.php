<?php
    require_once('new_login_connect.php');
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $con->prepare("SELECT u.*, ul.employee_id, ul.employee_email, ul.employee_password, 
                            r.role_url 
            FROM user u
            JOIN user_list ul ON u.employee_id = ul.employee_id
            JOIN role_type r ON u.user_role = r.role_id 
            WHERE ul.employee_email = ? AND ul.employee_password = ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $role_url = $row['role_url'];
        if ($row['user_status'] == 0) {
            echo '<script type="text/javascript">alert("Account is disabled. Please contact the administrator.");
            window.location.href="new_login.php"</script>';
            exit;
        }
        $_SESSION['employee_id'] = $row['employee_id']; // Store user's id in session
        $_SESSION['session_id'] = uniqid(); // Generate a unique session ID
        header("Location: " . $role_url);
        exit;
    }

    mysqli_close($con);
?>