<?php
  require_once('home_connect.php');

  if (isset($_SESSION['employee_id'])) {
      $employee_id = $_SESSION['employee_id'];
      
      $role_sql = "SELECT user.employee_id, user_list.employee_id, role_type.role_name
                  FROM user 
                  JOIN user_list ON user.employee_id = user_list.employee_id
                  JOIN role_type ON user.user_role = role_type.role_id
                  WHERE user.employee_id = $employee_id";
      $role_result = mysqli_query($con, $role_sql);

      if ($role_result) {
          $row = mysqli_fetch_assoc($role_result);
          $roletype = $row['role_name'];
      } else {
          $error_message = mysqli_error($con);
      }
  } 
  echo $roletype;
?>
