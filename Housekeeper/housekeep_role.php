<?php
  include('housekeep_connect.php');
  if (isset($_SESSION['user_email'])) {
      $user_email = $_SESSION['user_email'];
      
      $role_sql = "SELECT user_role FROM user WHERE user_email = '$user_email'";
      $role_result = mysqli_query($con, $role_sql);

      if ($role_result) {
          $row = mysqli_fetch_assoc($role_result);
          $roletype = $row['user_role'];
      } 
      else {
        $error_message = mysqli_error($con);
      }
  } echo $roletype;
?>
