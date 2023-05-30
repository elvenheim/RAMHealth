<?php
require_once('air_technician_connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sensor_id = $_POST['aq_sensor_id'];
    $sensor_status = $_POST['aq_sensor_status'];

    $sql = "UPDATE aq_sensor SET aq_sensor_status = '$sensor_status' WHERE aq_sensor_id = '$sensor_id'";
    if (mysqli_query($con, $sql)) {
        $response = array('status' => 'success', 'aq_sensor_status' => $sensor_status);
    } else {
        $response = array('status' => 'error');
    }
    echo json_encode($response);
}
?>
