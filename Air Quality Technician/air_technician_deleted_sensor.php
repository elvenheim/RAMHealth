<?php
require_once('air_technician_connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $sensor_id = $_POST['sensor_id'];

    // Disable foreign key checks
    mysqli_query($con, "SET FOREIGN_KEY_CHECKS = 0");

    // Retrieve the sensor data before deleting
    $select_query = "SELECT * FROM aq_sensor WHERE aq_sensor_id = ?";
    $stmt = mysqli_prepare($con, $select_query);
    mysqli_stmt_bind_param($stmt, 's', $sensor_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    // Insert data into deleted_aq_sensors table
    $insert_query = "INSERT INTO deleted_aq_sensors (deleted_aq_sensor_id, deleted_aq_sensor_room_num, deleted_aq_sensor_type_id, 
                                                    deleted_aq_sensor_name, deleted_aq_sensor_add_at, deleted_aq_sensor_deleted_at) 
                    VALUES (?, ?, ?, ?, ?, NOW())";
    $stmt = mysqli_prepare($con, $insert_query);
    $deleted_aq_sensor_type_id = $row['aq_sensor_type'];
    mysqli_stmt_bind_param($stmt, 'ssiss', $row['aq_sensor_id'], $row['aq_sensor_room_num'], $deleted_aq_sensor_type_id, 
                        $row['aq_sensor_name'], $row['aq_sensor_added_at']);
    mysqli_stmt_execute($stmt);

    // Delete the sensor from the aq_sensor table
    $delete_query = "DELETE FROM aq_sensor WHERE aq_sensor_id = ?";
    $stmt = mysqli_prepare($con, $delete_query);
    mysqli_stmt_bind_param($stmt, 's', $sensor_id);
    mysqli_stmt_execute($stmt);

    // Enable foreign key checks
    mysqli_query($con, "SET FOREIGN_KEY_CHECKS = 1");

    if (mysqli_stmt_affected_rows($stmt) > 0) {
        echo $sensor_id . " has been deleted successfully.";
    } else {
        echo "Error deleting sensor: " . mysqli_error($con);
    }
}
?>
