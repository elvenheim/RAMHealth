<?php
require_once('admin_connect.php');

  $user_id = $_POST['user_id'];
  $user_status = $_POST['user_status'];

  $sql = "UPDATE user SET user_status = $user_status WHERE user_id = $user_id";
  if (mysqli_query($con, $sql)) {
    $response = array('status' => 'success', 'user_status' => $user_status);
  } else {
    $response = array('status' => 'error');
  } echo json_encode($response);

?>
