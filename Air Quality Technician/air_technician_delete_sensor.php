<?php
    require_once('air_technician_connect.php');
    
    $sensor_id = $_POST['sensor_id'];
    
    $delete_query = "DELETE FROM sensor WHERE sensor_id = ?";
    $stmt = mysqli_prepare($con, $delete_query);
    mysqli_stmt_bind_param($stmt, 'i', $sensor_id);
    mysqli_stmt_execute($stmt);
    
    if (mysqli_stmt_affected_rows($stmt) > 0) {
        echo $sensor_id . "has been deleted successfully.";
    } else {
        echo "Error deleting sensor" . mysqli_error($con);
    }
?>
