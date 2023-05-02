<?php
    require_once('energy_technician_connect.php');

    $room_num = $_POST['room_num'];
    $sensor_type = $_POST['sensor_type'];
    $sensor_name = $_POST['sensor_name'];
    $sensor_created_at = date('Y-m-d');

    // Check if user_id already exists in the database
    $select_query = "SELECT sensor_name FROM sensor WHERE sensor_name = ?";
    $stmt = mysqli_prepare($con, $select_query);
    mysqli_stmt_bind_param($stmt, 's', $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if(mysqli_num_rows($result) > 0) {
        echo '<script type="text/javascript">alert("Sensor already exists");
            window.location.href="admin.php"</script>';
        exit;
    }

    $insert_query = "INSERT INTO sensor (sensor_room_num, sensor_type, sensor_name, sensor_added_at) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($con, $insert_query);
    mysqli_stmt_bind_param($stmt, 'siss', $room_num, $sensor_type, $sensor_name, $sensor_created_at);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) > 0) {
        echo '<script type="text/javascript">alert("Sensor added successfully");
            window.location.href="admin.php"</script>';
        exit;
    } else {
        echo '<script type="text/javascript">alert("Error adding sensor...");
            window.location.href="admin.php"</script>';
        exit;
    }

?>
