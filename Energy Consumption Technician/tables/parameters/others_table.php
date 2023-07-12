<?php     
    require_once('energy_technician_connect.php');
    
    if (isset($_POST['submit']) && isset($_POST['room_number'])) {
        $selectedSensors = $_POST['room_number'];

        $othSensors = implode("','", $selectedSensors);

        $rows_per_page = 10;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $rows_per_page;
    
        $count_query = "SELECT COUNT(*) as count FROM ec_param_others_data";
        $count_result = mysqli_query($con, $count_query);
        $count_row = mysqli_fetch_assoc($count_result);
        $total_rows = $count_row['count'];
    
        $total_pages = ceil($total_rows / $rows_per_page);
    
        $sql = "SELECT oth.*, eas.arduino_bldg_floor, eas.arduino_room_num, bf.bldg_floor_name
                FROM ec_param_others_data oth
                JOIN ec_arduino_sensors eas ON oth.ec_sensor_others_id = eas.ec_arduino_sensors_id
                LEFT JOIN room_number rn ON eas.arduino_room_num = rn.room_num
                LEFT JOIN building_floor bf ON rn.bldg_floor = bf.building_floor
                INNER JOIN (SELECT ec_sensor_others_id, MAX(CONCAT(ec_others_date, ' ', ec_others_time)) AS max_datetime
                        FROM ec_param_others_data
                        GROUP BY ec_sensor_others_id) AS latest 
                        ON oth.ec_sensor_others_id = latest.ec_sensor_others_id 
                AND CONCAT(oth.ec_others_date, ' ', oth.ec_others_time) = latest.max_datetime
                WHERE eas.arduino_room_num IN ('$othSensors')
                ORDER BY oth.ec_sensor_others_id ASC
                LIMIT $offset, $rows_per_page";
    
        $result_table = mysqli_query($con, $sql);
    
        if (!$result_table) {
            echo "Error: " . mysqli_error($con);
        }
        if (mysqli_num_rows($result_table) == 0) {
            echo "<tr><td colspan='6'>No data recorded.</td></tr>";
        } else {
            while ($row = mysqli_fetch_assoc($result_table)){
                echo "<tr>";
                echo "<td>" . $row['bldg_floor_name'] . "</td>";
                echo "<td>" . $row['arduino_room_num'] . "</td>";
                echo "<td>" . $row['ec_sensor_others_id'] . "</td>";
                echo "<td>" . $row['ec_others_date'] . "</td>";
                echo "<td>" . $row['ec_others_time'] . "</td>";
                echo "<td>" . $row['ec_others_current']  . ' amps' . "</td>";
                echo "</tr>";
            }   
        }
    }
?>
