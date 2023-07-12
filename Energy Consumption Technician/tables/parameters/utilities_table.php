<?php     
    require_once('energy_technician_connect.php');
    
    if (isset($_POST['submit']) && isset($_POST['room_number'])) {
        $selectedSensors = $_POST['room_number'];

        $utlSensors = implode("','", $selectedSensors);

        $rows_per_page = 10;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $rows_per_page;
    
        $count_query = "SELECT COUNT(*) as count FROM ec_param_util_data";
        $count_result = mysqli_query($con, $count_query);
        $count_row = mysqli_fetch_assoc($count_result);
        $total_rows = $count_row['count'];
    
        $total_pages = ceil($total_rows / $rows_per_page);
    
        $sql = "SELECT utl.*, eas.arduino_bldg_floor, eas.arduino_room_num, bf.bldg_floor_name
                FROM ec_param_util_data utl
                JOIN ec_arduino_sensors eas ON utl.ec_sensor_util_id = eas.ec_arduino_sensors_id
                LEFT JOIN room_number rn ON eas.arduino_room_num = rn.room_num
                LEFT JOIN building_floor bf ON rn.bldg_floor = bf.building_floor
                INNER JOIN (SELECT ec_sensor_util_id, MAX(CONCAT(ec_util_date, ' ', ec_util_time)) AS max_datetime
                        FROM ec_param_util_data
                        GROUP BY ec_sensor_util_id) AS latest 
                        ON utl.ec_sensor_util_id = latest.ec_sensor_util_id 
                AND CONCAT(utl.ec_util_date, ' ', utl.ec_util_time) = latest.max_datetime
                WHERE eas.arduino_room_num IN ('$utlSensors')
                ORDER BY utl.ec_sensor_util_id ASC
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
                echo "<td>" . $row['ec_sensor_util_id'] . "</td>";
                echo "<td>" . $row['ec_util_date'] . "</td>";
                echo "<td>" . $row['ec_util_time'] . "</td>";
                echo "<td>" . $row['ec_util_current']  . ' amps' . "</td>";
                echo "</tr>";
            }   
        }
    }
?>
