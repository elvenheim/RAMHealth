<?php
    require_once('energy_technician_connect.php');

    $panel_group = $_POST['panel_grouping'];
    $panel_label = $_POST['panel_label'];
    $bldg_floor = $_POST['bldg_floor'];
    $room_num = $_POST['room_number'];
    $arduino_label = $_POST['arduino_id'];
    $sensor_id = $_POST['sensor_id'];
    $sensor_type = $_POST['sensor_type'];
    $sensor_created_at = date('Y-m-d');

    mysqli_query($con, "SET foreign_key_checks = 0");

    $arduino_query= "INSERT IGNORE INTO ec_arduino_label_sensor (ec_arduino_sensor_label_id) VALUES (?)";
    $stmt= mysqli_prepare($con, $arduino_query);
    mysqli_stmt_bind_param($stmt,'s',$arduino_label);
    mysqli_stmt_execute($stmt);

    $insert_query = "INSERT IGNORE INTO ec_arduino_sensors (ec_arduino_sensors_id, arduino_bldg_floor, arduino_room_num, 
                    ec_arduino_sensors_type, arduino_sensors_added_at) 
                    VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($con, $insert_query);
    mysqli_stmt_bind_param($stmt, 'sisis', $sensor_id, $bldg_floor, $room_num, $sensor_type, $sensor_created_at);
    mysqli_stmt_execute($stmt);

    $link_query = "INSERT INTO ec_arduino_sensor_linking (ec_panel_grouping_id, ec_panel_label_id, 
                ec_arduino_sensor_label_id, ec_arduino_sensors_id, ec_arduino_deleted_sensor)
                VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($con, $link_query);
    mysqli_stmt_bind_param($stmt, 'sssss', $panel_group, $panel_label, $arduino_label, $sensor_id, $sensor_id);
    mysqli_stmt_execute($stmt);

    mysqli_query($con, "SET foreign_key_checks = 1");

    if (mysqli_stmt_affected_rows($stmt) > 0) {
        echo '<script type="text/javascript">alert("Sensor added successfully");
            window.history.back();</script>';
        exit;
    } else {
        echo '<script type="text/javascript">alert("Error adding sensor...");
            window.history.back();</script>';
        exit;
    }    
?>
