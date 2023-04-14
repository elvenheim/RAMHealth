<?php
    session_start();
    require('new_login.php');
    $email = $_POST['email'];
    $password = $_POST['password'];

    $_SESSION['user_email'] = $email;

    $stmt = $con->prepare("SELECT * FROM user WHERE user_email = ? AND user_password = ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $roles = array(
            "1" => "../Administrator/admin.php",
            "2" => "../Housekeeper/housekeeper.php",
            "3" => "../Air Quality Technician/air_technician.php",
            "4" => "../Energy Consumption Technician/energy_technician.php",
            "5" => "../Building Management Head/building_head.html"
        );
        $role = $row['user_role'];
        if (array_key_exists($role, $roles)) {
            header("Location: " . $roles[$role]);
            exit;
        }
    }
    echo '<script type="text/javascript">alert("Incorrect Email or Password");
    window.location.href="new_login.html"</script>';
    exit;
?>
