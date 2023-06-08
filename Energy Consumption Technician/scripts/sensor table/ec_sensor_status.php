<?php
    require_once('../../../Energy Consumption Technician/energy_technician_connect.php');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $sensor_id = $_POST['ec_arduino_sensors_id'];
        $sensor_status = $_POST['sensor_status'];

        $sql = "UPDATE ec_arduino_sensors SET arduino_sensors_status = '$sensor_status' WHERE ec_arduino_sensors_id = '$sensor_id'";
        if (mysqli_query($con, $sql)) {
            $response = array('status' => 'success', 'sensor_status' => $sensor_status);
        } else {
            $response = array('status' => 'error');
        }
        echo json_encode($response);
    }
?>
