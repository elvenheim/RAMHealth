require_once('admin_connect.php');

  $user_id = $_POST['user_id'];
  $user_role = $_POST['user_role'];

  $sql = "UPDATE user SET user_role = $user_role WHERE user_id = $user_id";
  if (mysqli_query($con, $sql)) {
    $response = array('status' => 'success', 'user_role' => $user_role);
  } else {
    $response = array('status' => 'error');
} echo json_encode($response);