<?php
require_once('air_technician_connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $sensor_id = $_POST['sensor_id'];

    // Disable foreign key checks
    mysqli_query($con, "SET FOREIGN_KEY_CHECKS = 0");

    // Retrieve the sensor data before restoring
    $select_query = "SELECT * FROM deleted_aq_sensors WHERE deleted_aq_sensor_id = ?";
    $stmt = mysqli_prepare($con, $select_query);
    mysqli_stmt_bind_param($stmt, 's', $sensor_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    // Insert data into aq_sensor table
    $insert_query = "INSERT INTO aq_sensor (aq_sensor_id, aq_sensor_room_num, aq_sensor_type, 
                                            aq_sensor_name, aq_sensor_added_at) 
                    VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($con, $insert_query);
    mysqli_stmt_bind_param($stmt, 'ssiss', $row['deleted_aq_sensor_id'], $row['deleted_aq_sensor_room_num'], $row['deleted_aq_sensor_type_id'], 
                        $row['deleted_aq_sensor_name'], $row['deleted_aq_sensor_add_at']);
    mysqli_stmt_execute($stmt);

    // Delete the sensor from the deleted_aq_sensors table
    $delete_query = "DELETE FROM deleted_aq_sensors WHERE deleted_aq_sensor_id = ?";
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
