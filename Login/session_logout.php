<?php
    require_once('path/to/admin_role.php');
    require_once('path/to/housekeeper.php');
    require_once('path/to/air_techncian.php');
    require_once('path/to/energy_technician.php');
    require_once('path/to/building_head.php');

    if (isset($_POST['logout'])) {
        session_destroy();
        header("Location: new_login.php");
        exit;
    }
?>
