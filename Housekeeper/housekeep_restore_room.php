<?php
require_once('housekeep_connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the room number from the request
    $room_number = $_POST['room_num'];

    // Retrieve the deleted room data from the deleted_room_num table
    $select_query = "SELECT * FROM deleted_room_num WHERE room_num = ?";
    $stmt = mysqli_prepare($con, $select_query);
    mysqli_stmt_bind_param($stmt, 's', $room_number);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    // Insert the restored room data into the room_number table
    $insert_query = "INSERT INTO room_number (room_num, bldg_floor, room_type, room_name, room_added_at) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($con, $insert_query);
    mysqli_stmt_bind_param($stmt, 'sisss', $row['room_num'], $row['bldg_floor'], $row['room_type'], $row['room_name'], $row['room_added_at']);
    mysqli_stmt_execute($stmt);

    // Delete the restored room data from the deleted_room_num table
    $delete_query = "DELETE FROM deleted_room_num WHERE room_num = ?";
    $stmt = mysqli_prepare($con, $delete_query);
    mysqli_stmt_bind_param($stmt, 's', $room_number);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) > 0) {
        echo "Room has been restored successfully.";
    } else {
        echo "Error restoring room: " . mysqli_error($con);
    }
}
?>
