<?php
  require_once('housekeep_connect.php');
    
  if (isset($_SESSION['user_id'])) {
      $stmt = $con->prepare("SELECT user_fullname FROM user WHERE user_id = ?");
      $stmt->bind_param("i", $_SESSION['user_id']);
      $stmt->execute();
      $result = $stmt->get_result();

      if ($result->num_rows > 0) {
          $row = $result->fetch_assoc();
          $_SESSION['user_fullname'] = $row['user_fullname'];
      }
  }
  echo $_SESSION['user_fullname'];
?>
