<?php
    require_once('../../../Energy Consumption Technician/energy_technician_connect.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $sensor_id = $_POST['sensor_id'];

        // Disable foreign key checks
        mysqli_query($con, "SET FOREIGN_KEY_CHECKS = 0");

        // Retrieve the sensor data before deleting
        $select_query = "SELECT * FROM ec_arduino_sensors WHERE ec_arduino_sensors_id = ?";
        $stmt = mysqli_prepare($con, $select_query);
        mysqli_stmt_bind_param($stmt, 's', $sensor_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);

        // Insert data into deleted_aq_sensors table
        $insert_query = "INSERT INTO deleted_ec_sensors (ec_arduino_sensor_id, arduino_bldg_floor, arduino_room_num, 
                        arduino_sensors_type, arduino_sensors_added_at, arduino_sensors_deleted_at) 
                        VALUES (?, ?, ?, ?, ?, NOW())";
        $stmt = mysqli_prepare($con, $insert_query);
        $deleted_ec_sensor_type_id = $row['ec_arduino_sensors_type'];
        mysqli_stmt_bind_param($stmt, 'sssis', $row['ec_arduino_sensors_id'], $row['arduino_bldg_floor'],
                        $row['arduino_room_num'], $deleted_ec_sensor_type_id, 
                        $row['arduino_sensors_added_at']);
        mysqli_stmt_execute($stmt);

        // Delete the sensor from the aq_sensor table
        $delete_query = "DELETE FROM ec_arduino_sensors WHERE ec_arduino_sensors_id = ?";
        $stmt = mysqli_prepare($con, $delete_query);
        mysqli_stmt_bind_param($stmt, 's', $sensor_id);
        mysqli_stmt_execute($stmt);

        // Enable foreign key checks
        mysqli_query($con, "SET FOREIGN_KEY_CHECKS = 1");

        if (mysqli_stmt_affected_rows($stmt) > 0) {
            echo $sensor_id . " has been deleted successfully.";
        } else {
            $error_message = mysqli_error($con);
            echo "Error deleting sensor: " . $error_message;
            error_log($error_message);
        }
    }
?>
