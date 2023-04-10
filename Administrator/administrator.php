<?php
  require_once('admin_connect.php');

  // Get the user's full name from the database
  $userId = 'user_id'; // Replace with the ID of the current user
  $query = "SELECT user_fullname FROM user WHERE user_id = $userId";
  $result = mysqli_query($conn, $query);

  if ($result && mysqli_num_rows($result) > 0) {
    // Set the full name as the text for the span element
    $row = mysqli_fetch_assoc($result);
    $fullName = $row['user_fullname'];
    echo "<script>document.getElementById('user_full_name').innerHTML = '$fullName';</script>";
  } else {
    // Handle the case where the user's full name could not be retrieved
    echo "Error: Unable to retrieve user's full name";
  }

?>