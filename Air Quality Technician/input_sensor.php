<?php 
    require_once('air_technician_connect.php');

    $roleIdsQuery = "SELECT sensor_type_id, sensor_type_name FROM sensor_type";
    $roleIdsResult = mysqli_query($con, $roleIdsQuery);
    
    echo '<label for="sensor_type">Sensor Type:</label>';
    echo '<select id="sensor_type" name="sensor_type" class="sensor_type" required>';
    echo '<option value="" disabled selected>-Select Sensor Type-</option>';
    while ($row = mysqli_fetch_assoc($roleIdsResult)) {
        if ($row['sensor_type_id'] == 1) {
            echo '<option value="' . $row['sensor_type_id'] . '" enabled>' . 
            $row['sensor_type_name'] . '</option>';
        }
    }
    echo '</select><br>';
?>
