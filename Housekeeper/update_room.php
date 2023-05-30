<?php
    require_once('housekeep_connect.php');
    // update_room.php

    // Check if the form is submitted and the necessary parameters are present
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['room_num'], $_POST['new_room_num'], $_POST['bldg_floor'], $_POST['room_type'], $_POST['room_name'])) {
        $roomNum = $_POST['room_num'];
        $newroomNum = $_POST['new_room_num'];
        $bldgFloor = $_POST['bldg_floor'];
        $roomType = $_POST['room_type'];
        $roomName = $_POST['room_name'];
        $room_created_at = date('Y-m-d');

        mysqli_query($con, "SET FOREIGN_KEY_CHECKS = 0");

        // Perform the necessary validation and sanitization of the inputs

        // Delete the existing room record
        $deleteQuery = "DELETE FROM room_number WHERE room_num = '$roomNum'";
        mysqli_query($con, $deleteQuery);

        // Insert the new room record with the updated room_num
        $insertQuery = "INSERT INTO room_number (room_num, bldg_floor, room_type, room_name, room_added_at) 
            VALUES ('$newroomNum', '$bldgFloor', '$roomType', '$roomName', NOW())";
        
        mysqli_query($con, "SET FOREIGN_KEY_CHECKS = 1");

        if (mysqli_query($con, $insertQuery)) {
            echo '<script type="text/javascript">alert("Room updated successfully.");
            window.location.href="housekeeper.php"</script>';
        } else {
            echo 'Error updating room: ' . mysqli_error($con);
        }
    } else {
        echo 'Invalid request.';
    }
?>
