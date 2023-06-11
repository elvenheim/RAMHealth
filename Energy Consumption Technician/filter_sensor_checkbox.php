<?php 
    require_once('energy_technician_connect.php');

    if (isset($_POST['selected_arduino'])) {
        $selectedArduino = $_POST['selected_arduino'];

        // Modify the arduino label query based on the selected group
        $sensorQuery = "SELECT easl.*, epg.ec_panel_grouping_id, epl.ec_panel_label_id, eas.arduino_bldg_floor, 
                            eas.arduino_room_num, st.sensor_type_name, eas.arduino_sensors_status, eas.ec_arduino_sensors_id,
                            eas.arduino_sensors_added_at, eals.ec_arduino_sensor_label_id, bf.bldg_floor_name
                    FROM ec_arduino_sensor_linking easl
                    INNER JOIN ec_arduino_sensors eas ON easl.ec_arduino_sensors_id = eas.ec_arduino_sensors_id
                    LEFT JOIN ec_panel_grouping epg ON easl.ec_panel_grouping_id = epg.ec_panel_grouping_id 
                    LEFT JOIN ec_panel_label epl ON easl.ec_panel_label_id = epl.ec_panel_label_id 
                    LEFT JOIN ec_arduino_label_sensor eals ON easl.ec_arduino_sensor_label_id = eals.ec_arduino_sensor_label_id 
                    LEFT JOIN deleted_ec_sensors decs ON easl.ec_arduino_deleted_sensor = decs.ec_arduino_sensor_id
                    LEFT JOIN room_number rn ON eas.arduino_bldg_floor = rn.bldg_floor AND eas.arduino_room_num = rn.room_num
                    LEFT JOIN building_floor bf ON rn.bldg_floor = bf.building_floor
                    LEFT JOIN sensor_type st ON eas.ec_arduino_sensors_type = st.sensor_type_id
                    WHERE easl.ec_arduino_sensor_label_id = ?";
        $stmt = mysqli_prepare($con, $sensorQuery);
        mysqli_stmt_bind_param($stmt, 's', $selectedArduino);
        mysqli_stmt_execute($stmt);
        $sensorResult = mysqli_stmt_get_result($stmt);

        echo '<label for="arduino_sensor">Sensor:</label>';
        echo '<div class="checkbox-dropdown">';
        echo '<button class="button-select-sensor" type="button" id="room-number-dropdown" onclick="toggleDropdown()">';
        echo '-Select Sensor-';
        echo '</button>';
        echo '<div class="dropdown-menu" id="sensor-menu">';
        echo '<div class="dropdown-item">';
        echo '<input type="checkbox" id="select-all" class="select-all" onclick="selectAll(this)" value="select-all">';
        echo '<label for="select-all">Select All</label>';
        echo '</div>';
        
        while ($row = mysqli_fetch_assoc($sensorResult)) {
            echo '<div class="dropdown-item">';
            echo '<input type="checkbox" id="' . $row['ec_arduino_sensors_id'] . '" name="ec_sensor[]" value="' . $row['ec_arduino_sensors_id'] . '">';
            echo '<label for="' . $row['ec_arduino_sensors_id'] . '">' . $row['ec_arduino_sensors_id'] . '</label>';
            echo '</div>';
        }
        echo '<button button id="submit-sensor" type="submit" name="submit" class="submit-button">Submit</button>';
        echo '</div>';
        echo '</div>';
    }
?>