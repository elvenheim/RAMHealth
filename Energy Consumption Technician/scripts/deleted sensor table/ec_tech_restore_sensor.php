<?php
    require_once('../../../Energy Consumption Technician/energy_technician_connect.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $sensor_id = $_POST['sensor_id'];

        // Disable foreign key checks
        mysqli_query($con, "SET FOREIGN_KEY_CHECKS = 0");

        // Retrieve the sensor data before restoring
        $select_query = "SELECT * FROM deleted_ec_sensors WHERE ec_arduino_sensor_id = ?";
        $stmt = mysqli_prepare($con, $select_query);
        mysqli_stmt_bind_param($stmt, 's', $sensor_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);

        // Insert data into aq_sensor table
        $insert_query = "INSERT INTO ec_arduino_sensors (ec_arduino_sensors_id, arduino_bldg_floor, arduino_room_num, 
                                                ec_arduino_sensors_type, arduino_sensors_added_at) 
                        VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($con, $insert_query);
        mysqli_stmt_bind_param($stmt, 'sssss', $row['ec_arduino_sensor_id'], $row['arduino_bldg_floor'], $row['arduino_room_num'], 
                            $row['arduino_sensors_type'], $row['arduino_sensors_added_at']);
        mysqli_stmt_execute($stmt);

        // Delete the sensor from the deleted_aq_sensors table
        $delete_query = "DELETE FROM deleted_ec_sensors WHERE ec_arduino_sensor_id = ?";
        $stmt = mysqli_prepare($con, $delete_query);
        mysqli_stmt_bind_param($stmt, 's', $sensor_id);
        mysqli_stmt_execute($stmt);

        // Enable foreign key checks
        mysqli_query($con, "SET FOREIGN_KEY_CHECKS = 1");

        if (mysqli_stmt_affected_rows($stmt) > 0) {
            echo $sensor_id . " has been restored successfully.";
        } else {
            echo "Error restoring sensor: " . mysqli_error($con);
        }
    }
?>
