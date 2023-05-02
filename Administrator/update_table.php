<?php
    require_once('admin_connect.php');

    // Check if the form was submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
        // Loop through each row in the table and update its values
        foreach ($_POST['data'] as $row) {
            $user_id = $row['user_id'];
            $user_fullname = $row['user_fullname'];
            $user_email = $row['user_email'];

            $sql = "UPDATE user SET user_fullname='$user_fullname', user_email='$user_email' WHERE user_id=$user_id";

            if ($con->query($sql) !== TRUE) {
                $response = array('status' => 'error', 'message' => $con->error);
                echo json_encode($response);
                exit();
            }            
            
        }

        $con->close();

        // Return success response
        $response = array('status' => 'success');
        echo json_encode($response);

        exit();
    }
?>
