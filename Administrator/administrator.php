<?php
  session_start();
  include('admin_connect.php');
  if (isset($_SESSION['user_email'])) {
      $user_email = $_SESSION['user_email'];
    
      $sql = "SELECT user_fullname FROM user WHERE user_email = '$user_email'";
      $result = mysqli_query($con, $sql);

      if ($result) {
          $row = mysqli_fetch_assoc($result);
          $fullname = $row['user_fullname'];
      } 
      else {
        $error_message = mysqli_error($con);
      }
  } 
  else {
    header('Location: login.php');
    exit;
  } echo $fullname;
?>
