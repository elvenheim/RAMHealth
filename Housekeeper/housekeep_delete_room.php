<?php
    require_once('housekeep_connect.php');
    
    $room_number = $_POST['room_num'];
    
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
