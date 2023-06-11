<?php 
    require_once('energy_technician_connect.php');

    $arduinolabelQuery = "SELECT ec_arduino_sensor_label_id FROM ec_arduino_label_sensor WHERE ec_arduino_type BETWEEN 6 AND 10";
    $arduinolabelResult = mysqli_query($con, $arduinolabelQuery);
    
    echo '<label for="arduino_label">Arduino ID:</label>';
    echo '<select id="arduino_label" name="arduino_label" class="arduino_label" required>';
    echo '<option value="" disabled selected>-Select Arduino ID-</option>';
    while ($row = mysqli_fetch_assoc($arduinolabelResult)) {
        echo '<option value="' . $row['ec_arduino_sensor_label_id'] . '">' . $row['ec_arduino_sensor_label_id'] . '</option>';
    }
    echo '</select><br>';
?>