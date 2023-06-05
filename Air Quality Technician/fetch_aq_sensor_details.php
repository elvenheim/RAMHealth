<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RAM Health</title> 
    <link rel="stylesheet" href="../Air Quality Technician/AQ Tech Design/aq_sensor_edit.css">
    <link rel="shortcut icon" href="../favicons/favicon.ico"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.3.0/css/all.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

    <?php
        require_once('air_technician_connect.php');
        
        // Check if the form is submitted and the employee_id parameter is present
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['aq_sensor_id'])) {
            $AQsensorId = $_POST['aq_sensor_id'];
            
            // Retrieve the employee details from the database based on the employee ID
            $query = "SELECT * FROM aq_sensor WHERE aq_sensor_id = '$AQsensorId'";
            $result = mysqli_query($con, $query);
            
            // Check if the employee exists
            if (mysqli_num_rows($result) > 0) {
                $aq_sensor = mysqli_fetch_assoc($result);

                echo '<div class="form-container">';
                echo '<form method="post" action="update_aq_sensor.php">';
                
                echo '<div class="form-title">';
                echo 'Edit Sensor';
                echo '</div>';

                echo '<div style="display: none;">';
                echo 'Sensor ID: <input type="text" name="sensor_id" value="' . $aq_sensor['aq_sensor_id'] . '" readonly>';
                echo '</div>';

                echo '<label for="new_aq_sensor_id">Sensor ID:</label>';
                echo '<input type="text" name="new_aq_sensor_id" value="' . $aq_sensor['aq_sensor_id'] . '">';

                echo '<label for="new_aq_sensor_name">Sensor Name:</label>';
                echo '<input type="text" name="new_aq_sensor_name" value="' . $aq_sensor['aq_sensor_name'] . '">';

                //Selection for AQ Sensor Type
                $sensortypeIdsQuery = "SELECT sensor_type_id, sensor_type_name FROM sensor_type WHERE sensor_type_id BETWEEN 1 AND 5";
                $sensortypeIdsResult = mysqli_query($con, $sensortypeIdsQuery);
                
                echo '<label for="sensor_type">Sensor Type:</label>';
                echo '<select id="sensor_type" name="sensor_type" class="sensor_type" required>';
                echo '<option value="" disabled selected>-Select Sensor Type-</option>';
                while ($row = mysqli_fetch_assoc($sensortypeIdsResult)) {
                    echo '<option value="' . $row['sensor_type_id'] . '" ' . $selected . '>' . 
                        $row['sensor_type_name'] . '</option>';
                }
                echo '</select><br>';
                
                // Selection for Room Number
                $roomQuery = "SELECT room_num FROM room_number";
                $roomResult = mysqli_query($con, $roomQuery);
                
                echo '<label for="room_number">Room Number:</label>';
                echo '<select id="room_number" name="room_number" class="room_number" required>';
                echo '<option value="" disabled selected>-Select Room-</option>';
                while ($row = mysqli_fetch_assoc($roomResult)) {
                    echo '<option value="' . $row['room_num'] . '">' . $row['room_num'] . '</option>';
                }
                echo '</select><br>';
                
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
