<?php
  session_start();
  include('building_head_connect.php');
  if (isset($_SESSION['user_email'])) {
      $user_email = $_SESSION['user_email'];
    
      $fullname_sql = "SELECT user_fullname FROM user WHERE user_email = '$user_email'";
      $role_sql = "SELECT user_role FROM user WHERE user_email = '$user_email'";
      $name_result = mysqli_query($con, $fullname_sql);
      $role_result = mysqli_query($con, $role_sql);

      if ($name_result) {
          $row = mysqli_fetch_assoc($name_result);
          $fullname = $row['user_fullname'];
      } 
      else {
        $error_message = mysqli_error($con);
      }
  } echo $fullname;
?>
