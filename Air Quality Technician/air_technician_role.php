<?php
  include('air_technician_connect.php');
  if (isset($_SESSION['user_email'])) {
    $user_email = $_SESSION['user_email'];
    
    $role_sql = "SELECT user.user_email, role_type.role_name
                FROM user
                JOIN role_type ON user.user_role = role_type.role_id
                WHERE user.user_email = '$user_email'";
    $role_result = mysqli_query($con, $role_sql);

    if ($role_result) {
        $row = mysqli_fetch_assoc($role_result);
        $roletype = $row['role_name'];
    } 
    else {
      $error_message = mysqli_error($con);
    }
} 
echo $roletype;
?>
