<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RAM Health</title> 
    <link rel="stylesheet" href="../Energy Consumption Technician/EC Tech Design/ec_sensor_edit.css">
    <link rel="shortcut icon" href="../favicons/favicon.ico"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.3.0/css/all.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../Energy Consumption Technician/scripts/energy_technician.js"></script>
</head>
<body>
    <?php
        require_once('energy_technician_connect.php');
        
        // Check if the form is submitted and the employee_id parameter is present
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['ec_arduino_sensors_id'])) {
            $ECsensorId = $_POST['ec_arduino_sensors_id'];
            
            // Retrieve the employee details from the database based on the employee ID
            // $query = "SELECT * FROM ec_arduino_sensors WHERE ec_arduino_sensors_id = '$ECsensorId'";
            $query = "SELECT easl.*, epg.ec_panel_grouping_id, epl.ec_panel_label_id, eas.arduino_bldg_floor, 
                    eas.arduino_room_num, st.sensor_type_name, eas.arduino_sensors_status, eas.ec_arduino_sensors_id,
                    eas.arduino_sensors_added_at, eals.ec_arduino_sensor_label_id, bf.bldg_floor_name, eas.ec_arduino_sensors_type,
                    eas.arduino_sensors_added_at, eas.arduino_sensors_status
                    FROM ec_arduino_sensor_linking easl
                    INNER JOIN ec_arduino_sensors eas ON easl.ec_arduino_sensors_id = eas.ec_arduino_sensors_id
                    LEFT JOIN ec_panel_grouping epg ON easl.ec_panel_grouping_id = epg.ec_panel_grouping_id 
                    LEFT JOIN ec_panel_label epl ON easl.ec_panel_label_id = epl.ec_panel_label_id 
                    LEFT JOIN ec_arduino_label_sensor eals ON easl.ec_arduino_sensor_label_id = eals.ec_arduino_sensor_label_id 
                    LEFT JOIN deleted_ec_sensors decs ON easl.ec_arduino_deleted_sensor = decs.ec_arduino_sensor_id
                    LEFT JOIN room_number rn ON eas.arduino_bldg_floor = rn.bldg_floor AND eas.arduino_room_num = rn.room_num
                    LEFT JOIN building_floor bf ON rn.bldg_floor = bf.building_floor
                    LEFT JOIN sensor_type st ON eas.ec_arduino_sensors_type = st.sensor_type_id
                    WHERE eas.ec_arduino_sensors_id = '$ECsensorId'
                    ORDER BY bf.building_floor ASC, eas.arduino_sensors_status ASC, eas.ec_arduino_sensors_id";
            $result = mysqli_query($con, $query);
            
            // Check if the employee exists
            if (mysqli_num_rows($result) > 0) {
                $ec_sensor = mysqli_fetch_assoc($result);

                echo '<div class="form-container">';
                echo '<form method="post" action="update_ec_sensor.php">';
                
                echo '<div class="form-title">';
                echo 'Edit Sensor';
                echo '</div>';

                echo '<div style="display: none;">';
                echo 'Old Sensor ID: <input type="text" name="old_sensor_id" value="' . $ec_sensor['ec_arduino_sensors_id'] . '" readonly>';
                echo '</div>';

                // Select Panel Grouping
                $panelgroupQuery = "SELECT ec_panel_grouping_id FROM ec_panel_grouping";
                $panelgroupResult = mysqli_query($con, $panelgroupQuery);

                echo '<label for="panel_grouping">Panel Group:</label>';
                echo '<select id="panel_grouping" name="panel_grouping" class="panel_grouping" required>';
                while ($row = mysqli_fetch_assoc($panelgroupResult)) {
                    $selected = ($row['ec_panel_grouping_id'] == $ec_sensor['ec_panel_grouping_id']) ? 'selected' : '';
                    echo '<option value="' . $row['ec_panel_grouping_id'] . '" ' . $selected . '>' . $row['ec_panel_grouping_id'] . '</option>';
                }
                echo '</select><br>';

                // Select Panel Label
                $panellabelQuery = "SELECT ec_panel_label_id FROM ec_panel_label";
                $panellabelResult = mysqli_query($con, $panellabelQuery);

                echo '<label for="panel_label">Panel Label:</label>';
                echo '<select id="panel_label" name="panel_label" class="panel_label" required>';
                while ($row = mysqli_fetch_assoc($panellabelResult)) {
                    $selected = ($row['ec_panel_label_id'] == $ec_sensor['ec_panel_label_id']) ? 'selected' : '';
                    echo '<option value="' . $row['ec_panel_label_id'] . '" ' . $selected . '>' . $row['ec_panel_label_id'] . '</option>';
                }
                echo '</select><br>';

                // Select Sensor Floor
                $floorQuery = "SELECT rn.*, bf.building_floor, bf.bldg_floor_name
                            FROM room_number rn
                            JOIN building_floor bf ON rn.bldg_floor = bf.building_floor
                            GROUP BY bf.building_floor
                            ORDER BY bf.building_floor ASC";
                $floorResult = mysqli_query($con, $floorQuery);

                echo '<label for="bldg_floor">Building Floor:</label>';
                echo '<select id="bldg_floor" name="bldg_floor" class="bldg_floor" required>';
                while ($row = mysqli_fetch_assoc($floorResult)) {
                    $selected = ($row['building_floor'] == $ec_sensor['arduino_bldg_floor']) ? 'selected' : '';
                    echo '<option value="' . $row['building_floor'] . '" ' . $selected . '>' . $row['bldg_floor_name'] . '</option>';
                }
                echo '</select><br>';

                // Select Sensor Room
                $roomQuery = "SELECT room_num FROM room_number";
                $roomQueryResult = mysqli_query($con, $roomQuery);

                echo '<label for="room_number">Room Number:</label>';
                echo '<select id="room_number" name="room_number" class="room_number" required>';
                while ($row = mysqli_fetch_assoc($roomQueryResult)) {
                    $selected = ($row['room_num'] == $ec_sensor['arduino_room_num']) ? 'selected' : '';
                    echo '<option value="' . $row['room_num'] . '" ' . $selected . '>' . $row['room_num'] . '</option>';
                }
                echo '</select><br>';
                
                // Select Arduino Label
                $arduinolabelQuery = "SELECT ec_arduino_sensor_label_id FROM ec_arduino_label_sensor";
                $arduinolabelResult = mysqli_query($con, $arduinolabelQuery);

                echo '<label for="arduino_label">Arduino ID:</label>';
                echo '<select id="arduino_label" name="arduino_label" class="arduino_label" required>';
                while ($row = mysqli_fetch_assoc($arduinolabelResult)) {
                    $selected = ($row['ec_arduino_sensor_label_id'] == $ec_sensor['ec_arduino_sensor_label_id']) ? 'selected' : '';
                    echo '<option value="' . $row['ec_arduino_sensor_label_id'] . '" ' . $selected . '>' . $row['ec_arduino_sensor_label_id'] . '</option>';
                }
                echo '</select><br>';

                //New Sensor ID
                echo '<label for="new_ec_sensor_id">Sensor ID:</label>';
                echo '<input type="text" name="new_ec_sensor_id" value="' . $ec_sensor['ec_arduino_sensors_id'] . '">';

                // Selection for EC Sensor Type
                $sensortypeIdsQuery = "SELECT sensor_type_id, sensor_type_name FROM sensor_type WHERE sensor_type_id BETWEEN 6 AND 10";
                $sensortypeIdsResult = mysqli_query($con, $sensortypeIdsQuery);
                
                echo '<label for="sensor_type">Sensor Type:</label>';
                echo '<select id="sensor_type" name="sensor_type" class="sensor_type" required>';
                while ($row = mysqli_fetch_assoc($sensortypeIdsResult)) {
                    $selected = ($row['sensor_type_id'] == $ec_sensor['ec_arduino_sensors_type']) ? 'selected' : '';
                    echo '<option value="' . $row['sensor_type_id'] . '" ' . $selected . '>' . $row['sensor_type_name'] . '</option>';
                }
                echo '</select><br>';

                echo '<div style="display: none;">';
                echo 'Sensor Status: <input type="text" name="sensor_status" value="' . $ec_sensor['arduino_sensors_status'] . '" readonly>';
                echo '</div>';

                echo '<div style="display: none;">';
                echo 'Sensor ID: <input type="text" name="sensor_added_at" value="' . $ec_sensor['arduino_sensors_added_at'] . '" readonly>';
                echo '</div>';
                
                // Add other fields you want to edit
                echo '<div class="form-buttons">';
                echo '<input type="submit" value="Update">';
                echo '<button type="button" onclick="cancelEdit()">Cancel</button>';
                echo '</div>';

                echo '</form>';
                echo '</div>';
            } else {
                echo 'Sensor not found.';
            }
        } else {
            echo 'Invalid request.';
        }
    ?>
</body>
</html>
