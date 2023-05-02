<?php
  require_once('air_technician_connect.php');

  $sensor_id = $_POST['sensor_id'];
  $sensor_status = $_POST['sensor_status'];

  $sql = "UPDATE sensor SET sensor_status = $sensor_status WHERE sensor_id = $sensor_id";
  if (mysqli_query($con, $sql)) {
    $response = array('status' => 'success', 'sensor_status' => $sensor_status);
  } else {
    $response = array('status' => 'error');
  } echo json_encode($response);

?>
