<?php
    //LOGIN IS NOW SOFTCODED
    require_once('new_login_connect.php');
    $email = $_POST['email'];
    $password = $_POST['password'];

    $_SESSION['user_email'] = $email;

    $stmt = $con->prepare("SELECT user.*, role_type.role_url FROM user 
            JOIN role_type ON user.user_role = role_type.role_id 
            WHERE user.user_email = ? AND user.user_password = ?");
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
        if (!empty($role_url)) {
            header("Location: " . $role_url);
            exit;
        }
    }
    echo '<script type="text/javascript">alert("Incorrect Email or Password");
    window.location.href="new_login.php"</script>';
    exit;
?>