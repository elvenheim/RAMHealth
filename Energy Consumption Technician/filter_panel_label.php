<?php
    require_once('energy_technician_connect.php');

    if (isset($_POST['selected_panel_group'])) {
        $selectedPanelGroup = $_POST['selected_panel_group'];

        // Modify the panel label query based on the selected group
        $panellabelQuery = "SELECT easl.*, epg.ec_panel_grouping_id, epl.ec_panel_label_id, eas.arduino_bldg_floor, 
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
                            WHERE easl.ec_panel_grouping_id = ?
                            GROUP BY epl.ec_panel_label_id";
        $stmt = mysqli_prepare($con, $panellabelQuery);
        mysqli_stmt_bind_param($stmt, 's', $selectedPanelGroup);
        mysqli_stmt_execute($stmt);
        $panellabelResult = mysqli_stmt_get_result($stmt);

        // Generate the panel label dropdown options
        echo '<form id="panel-label-selection-form">';
        echo '<label for="panel_label">Panel Label:</label>';
        echo '<select id="panel_label" name="panel_label" class="panel_label" required onchange="updateArduinoLabelDropdown(this.value)">';
        echo '<option value="" disabled selected>-Select Label-</option>';
        while ($row = mysqli_fetch_assoc($panellabelResult)) {
        echo '<option value="' . $row['ec_panel_label_id'] . '">' . $row['ec_panel_label_id'] . '</option>';
        }
        echo '</select><br>';
        echo '</form>';
    }
?>
