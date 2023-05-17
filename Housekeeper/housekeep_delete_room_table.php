<?php
    require_once('housekeep_connect.php');

    // Retrieve data of the room that is being deleted
    $room_number = $_POST['room_num'];

    $select_query = "SELECT * FROM room_number WHERE room_num = ?";
    $stmt = mysqli_prepare($con, $select_query);
    mysqli_stmt_bind_param($stmt, 's', $room_number);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    // Insert data into deleted_room_num table
    $insert_query = "INSERT INTO deleted_room_num (room_num, bldg_floor, room_type, room_name, room_added_at, room_delete_at) VALUES (?, ?, ?, ?, ?, NOW())";
    $stmt = mysqli_prepare($con, $insert_query);
    mysqli_stmt_bind_param($stmt, 'sisss', $row['room_num'], $row['bldg_floor'], $row['room_type'], $row['room_name'], $row['room_added_at']);
    mysqli_stmt_execute($stmt);

    // Delete the room from the room_number table
    $delete_query = "DELETE FROM room_number WHERE room_num = ?";
    $stmt = mysqli_prepare($con, $delete_query);
    mysqli_stmt_bind_param($stmt, 's', $room_number);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) > 0) {
        echo "Room has been deleted successfully.";
    } else {
        echo "Error deleting room: " . mysqli_error($con);
    }
?>