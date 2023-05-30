<?php
    require_once('air_technician_connect.php');

    $sensor_id = $_POST['sensor_id'];
    $sensor_name = $_POST['sensor_name'];
    $sensor_type = $_POST['sensor_type'];
    $room_number = $_POST['room_number'];
    $sensor_created_at = date('Y-m-d');

    // Check if sensor id already exists in the database
    $select_query = "SELECT aq_sensor_id FROM aq_sensor WHERE aq_sensor_id = ?";
    $stmt = mysqli_prepare($con, $select_query);
    mysqli_stmt_bind_param($stmt, 's', $sensor_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if(mysqli_num_rows($result) > 0) {
        echo '<script type="text/javascript">alert("Sensor already exists");
            window.location.href="air_technician_sensor_main.php"</script>';
        exit;
    }

    $insert_query = "INSERT INTO aq_sensor (aq_sensor_id, aq_sensor_room_num, 
                                aq_sensor_type, aq_sensor_name, aq_sensor_added_at) 
                    VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($con, $insert_query);
    mysqli_stmt_bind_param($stmt, 'sssss', $sensor_id, $room_number, $sensor_type, $sensor_name, $sensor_created_at);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) > 0) {
        echo '<script type="text/javascript">alert("Sensor added successfully");
            window.location.href="air_technician_sensor_main.php"</script>';
        exit;
    } else {
        echo '<script type="text/javascript">alert("Error adding sensor...");
            window.location.href="air_technician_sensor_main.php"</script>';
        exit;
    }

?>
