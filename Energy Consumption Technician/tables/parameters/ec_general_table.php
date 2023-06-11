<?php     
    require_once('energy_technician_connect.php');
    
    $rows_per_page = 10;

    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

    $offset = ($page - 1) * $rows_per_page;

    $count_query = "SELECT COUNT(*) as count FROM energy_consumption_table";
    $count_result = mysqli_query($con, $count_query);
    $count_row = mysqli_fetch_assoc($count_result);
    $total_rows = $count_row['count'];

    $total_pages = ceil($total_rows / $rows_per_page);

    $sql = "SELECT acu.*, eas.arduino_bldg_floor, eas.arduino_room_num, bf.bldg_floor_name
            
            FROM ec_param_others_data acu
            JOIN ec_arduino_sensors eas ON acu.ec_sensor_others_id = eas.ec_arduino_sensors_id
            LEFT JOIN room_number rn ON eas.arduino_room_num = rn.room_num
            LEFT JOIN building_floor bf ON rn.bldg_floor = bf.building_floor
            INNER JOIN (SELECT ec_sensor_others_id, MAX(CONCAT(ec_others_date, ' ', ec_others_time)) AS max_datetime
                    FROM ec_param_others_data
                    GROUP BY ec_sensor_others_id) AS latest 
                    ON acu.ec_sensor_others_id = latest.ec_sensor_others_id 
            AND CONCAT(acu.ec_others_date, ' ', acu.ec_others_time) = latest.max_datetime
            WHERE eas.ec_arduino_sensors_id IN ('$acuSensors')
            ORDER BY acu.ec_sensor_others_id ASC
            LIMIT $offset, $rows_per_page";

    $result_table = mysqli_query($con, $sql);

    while ($row = mysqli_fetch_assoc($result_table)){
        echo "<tr>";
        echo "<td>" . ($row['building_floor'] !== null && $row['building_floor'] !== '' ? $row['building_floor'] . "" : "N/A") . "</td>";
        echo "<td>" . ($row['acu_current'] !== null && $row['acu_current'] !== '' ? $row['acu_current'] . " A" : "N/A") . "</td>";
        echo "<td>" . ($row['lighting_current'] !== null && $row['lighting_current'] !== '' ? $row['lighting_current'] . " A" : "N/A") . "</td>";        
        echo "<td>" . ($row['outlet_current'] !== null && $row['outlet_current'] !== '' ? $row['outlet_current'] . " A" : "N/A") . "</td>";
        echo "<td>" . ($row['utilities_current'] !== null && $row['utilities_current'] !== '' ? $row['utilities_current'] . " A" : "N/A") . "</td>";
        echo "<td>" . ($row['others_current'] !== null && $row['others_current'] !== '' ? $row['others_current'] . " A" : "N/A") . "</td>";
        echo "</tr>";
    }
    
?>