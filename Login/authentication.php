<?php
    require_once('new_login.php');

    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $con->prepare("SELECT * FROM user WHERE user_email = ? AND user_password = ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $roles = array(
            "administrator" => "../Administrator/admin.html",
            "housekeeper" => "../Housekeeper/housekeeper.html",
            "air technician" => "../Air Quality Technician/air_technician.html",
            "energy technician" => "../Energy Consumption Technician/energy_technician.html",
            "building head" => "../Building Management Head/building_head.html"
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
