<?php
    require_once('energy_technician_connect.php');
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Retrieve the updated sensor details from the form
        $panel_group = $_POST['panel_grouping'];
        $panel_label = $_POST['panel_label'];
        $bldg_floor = $_POST['bldg_floor'];
        $room_number = $_POST['room_number'];
        $arduino_label = $_POST['arduino_label'];
        $ec_sensor_id = $_POST['new_ec_sensor_id'];
        $deleted_ec_sensor_id = $_POST['new_ec_sensor_id'];
        $sensor_type = $_POST['sensor_type'];
        $sensor_added_at = $_POST['sensor_added_at'];
        $sensor_status = $_POST['sensor_status'];

        $old_ec_sensor_id = $_POST['old_sensor_id'];

        // Disable foreign key checks
        mysqli_query($con, "SET FOREIGN_KEY_CHECKS = 0");
        
        // Delete the existing row
        $deleteQuery = "DELETE FROM ec_arduino_sensors WHERE ec_arduino_sensors_id = ?";
        $deleteStatement = mysqli_prepare($con, $deleteQuery);
        mysqli_stmt_bind_param($deleteStatement, "s", $old_ec_sensor_id);
        $deleteResult = mysqli_stmt_execute($deleteStatement);
        
        if ($deleteResult) {
            // Insert the new row with updated data
            $insertQuery = "INSERT INTO ec_arduino_sensors (ec_arduino_sensors_id, arduino_bldg_floor, arduino_room_num,
                            ec_arduino_sensors_type, arduino_sensors_added_at, arduino_sensors_status) 
                            VALUES (?, ?, ?, ?, ?, ?)";
            $insertStatement = mysqli_prepare($con, $insertQuery);
            mysqli_stmt_bind_param($insertStatement, "ssssss", $ec_sensor_id, $bldg_floor, $room_number, $sensor_type, $sensor_added_at, $sensor_status);
            $insertResult = mysqli_stmt_execute($insertStatement);
            
            if ($insertResult) {
                $updateLinkingQuery = "UPDATE ec_arduino_sensor_linking
                                        SET ec_panel_grouping_id = ?,
                                            ec_panel_label_id = ?,
                                            ec_arduino_sensor_label_id = ?,
                                            ec_arduino_sensors_id = ?,
                                            ec_arduino_deleted_sensor = ?
                                        WHERE ec_arduino_sensors_id = ?";
                $updateLinkingStatement = mysqli_prepare($con, $updateLinkingQuery);
                mysqli_stmt_bind_param($updateLinkingStatement, "ssssss", $panel_group, $panel_label, $arduino_label, $ec_sensor_id, $deleted_ec_sensor_id, $old_ec_sensor_id);
                $updateLinkingResult = mysqli_stmt_execute($updateLinkingStatement);
        
                if ($updateLinkingResult) {
                    // Enable foreign key checks
                    mysqli_query($con, "SET FOREIGN_KEY_CHECKS = 1");
                    // Success message or redirect
                    echo '<script type="text/javascript">alert("Sensor updated successfully.");
                    window.location.href="energy_technician_sensor_main.php"</script>';
                } else {
                    echo 'Failed to update ec_arduino_sensor_linking.';
                }
            } else {
                echo 'Failed to insert new sensor data.';
            }
        } else {
            echo 'Failed to delete existing sensor.';
        }
    } else {
        echo 'Invalid request.';
    }
?>
