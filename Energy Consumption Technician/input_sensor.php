<?php 
    require_once('energy_technician_connect.php');

    $sensortypeIdsQuery = "SELECT sensor_type_id, sensor_type_name FROM sensor_type WHERE sensor_type_id BETWEEN 6 AND 10";
    $sensortypeIdsResult = mysqli_query($con, $sensortypeIdsQuery);
    
    echo '<label for="sensor_type">Sensor Type:</label>';
    echo '<select id="sensor_type" name="sensor_type" class="sensor_type" required>';
    echo '<option value="" disabled selected>-Select Sensor Type-</option>';
    while ($row = mysqli_fetch_assoc($sensortypeIdsResult)) {
        echo '<option value="' . $row['sensor_type_id'] . '" ' . $selected . '>' . 
            $row['sensor_type_name'] . '</option>';
    }
    echo '</select><br>';
?>
