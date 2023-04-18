<?php
    require_once('admin_connect.php');

    if (isset($_FILES['csv_file'])) {
        $file_path = $_FILES['csv_file']['tmp_name'];
        $handle = fopen($file_path, 'r');

        if ($handle !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
                $user_id = $data[0];
                $user_fullname = $data[1];
                $user_email = $data[2];
                $user_password = $data[3];
                $user_role = $data[4];
                $user_create_at = $data[5];
                $user_status = $data[6];

                // Check if the record already exists in the database
                $select_query = "SELECT * FROM user WHERE user_id = ?";
                $stmt = mysqli_prepare($con, $select_query);
                mysqli_stmt_bind_param($stmt, 'i', $user_id);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);

                if (mysqli_num_rows($result) > 0) {
                    // Record exists, update it with new data
                    $update_query = "UPDATE user SET user_role = ?, user_fullname = ?, user_email = ?, user_password = ?, user_create_at = ? WHERE user_id = ?";
                    $stmt = mysqli_prepare($con, $update_query);
                    mysqli_stmt_bind_param($stmt, 'sssssii', $user_role, $user_fullname, $user_email, $user_password, $user_create_at, $user_status, $user_id);
                    mysqli_stmt_execute($stmt);
                } else {
                    // Record does not exist, insert new record into the database
                    $insert_query = "INSERT INTO user (user_id, user_role, user_fullname, user_email, user_password, user_create_at) VALUES (?, ?, ?, ?, ?, ?)";
                    $stmt = mysqli_prepare($con, $insert_query);
                    mysqli_stmt_bind_param($stmt, 'isssssi', $user_id, $user_role, 
                    $user_fullname, $user_email, $user_password, $user_created_at, $user_status);
                    mysqli_stmt_execute($stmt);
                }
            }

            fclose($handle);
            unlink($file_path); // Delete temporary file from server
            echo '<script type="text/javascript">alert("Import successful");
                window.location.href="admin.php"</script>';
            exit;
        } else {
            echo '<script type="text/javascript">alert("Error opening file");
                window.location.href="admin.php"</script>';
            exit;
        }
    }
?>
