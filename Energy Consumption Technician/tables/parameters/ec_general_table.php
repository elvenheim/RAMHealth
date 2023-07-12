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


    $sql = "SELECT gec.*, eas.arduino_bldg_floor, eas.arduino_room_num, bf.bldg_floor_name
        FROM energy_consumption_table gec
        LEFT JOIN room_number rn ON eas.arduino_room_num = rn.room_num
        LEFT JOIN building_floor bf ON rn.bldg_floor = bf.building_floor
        INNER JOIN (SELECT ec_sensor_others_id, MAX(CONCAT(ec_others_date, ' ', ec_others_time)) AS max_datetime
                FROM ec_param_others_data
                GROUP BY ec_sensor_others_id) AS latest
                ON oth.ec_sensor_others_id = latest.ec_sensor_others_id 
        AND CONCAT(oth.ec_others_date, ' ', oth.ec_others_time) = latest.max_datetime
        WHERE eas.ec_arduino_sensors_id IN ('$othSensors')
        ORDER BY oth.ec_sensor_others_id ASC
        LIMIT $offset, $rows_per_page
        ";
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
            WHERE eas.ec_arduino_sensors_id IN ('$othSensors')
            ORDER BY oth.ec_sensor_others_id ASC
            LIMIT $offset, $rows_per_page";

    $sql = "SELECT acu.*, eas.arduino_bldg_floor, eas.arduino_room_num, bf.bldg_floor_name
    FROM ec_param_acu_data acu
    JOIN ec_arduino_sensors eas ON acu.ec_sensor_acu_id = eas.ec_arduino_sensors_id
    LEFT JOIN room_number rn ON eas.arduino_room_num = rn.room_num
    LEFT JOIN building_floor bf ON rn.bldg_floor = bf.building_floor
    INNER JOIN (SELECT ec_sensor_acu_id, MAX(CONCAT(ec_acu_date, ' ', ec_acu_time)) AS max_datetime
            FROM ec_param_acu_data
            GROUP BY ec_sensor_acu_id) AS latest 
            ON acu.ec_sensor_acu_id = latest.ec_sensor_acu_id 
    AND CONCAT(acu.ec_acu_date, ' ', acu.ec_acu_time) = latest.max_datetime
    WHERE eas.ec_arduino_sensors_id IN ('$acuSensors')
    ORDER BY acu.ec_sensor_acu_id ASC
    LIMIT $offset, $rows_per_page";

$sql = "SELECT outl.*, eas.arduino_bldg_floor, eas.arduino_room_num, bf.bldg_floor_name
FROM ec_param_outlet_data outl
JOIN ec_arduino_sensors eas ON outl.ec_sensor_outlet_id = eas.ec_arduino_sensors_id
LEFT JOIN room_number rn ON eas.arduino_room_num = rn.room_num
LEFT JOIN building_floor bf ON rn.bldg_floor = bf.building_floor
INNER JOIN (SELECT ec_sensor_outlet_id, MAX(CONCAT(ec_outlet_date, ' ', ec_outlet_time)) AS max_datetime
        FROM ec_param_outlet_data
        GROUP BY ec_sensor_outlet_id) AS latest 
        ON outl.ec_sensor_outlet_id = latest.ec_sensor_outlet_id 
AND CONCAT(outl.ec_outlet_date, ' ', outl.ec_outlet_time) = latest.max_datetime
WHERE eas.ec_arduino_sensors_id IN ('$outlSensors')
ORDER BY outl.ec_sensor_outlet_id ASC
LIMIT $offset, $rows_per_page";

$sql = "SELECT lght.*, eas.arduino_bldg_floor, eas.arduino_room_num, bf.bldg_floor_name
FROM ec_param_lights_data lght
JOIN ec_arduino_sensors eas ON lght.ec_sensor_lights_id = eas.ec_arduino_sensors_id
LEFT JOIN room_number rn ON eas.arduino_room_num = rn.room_num
LEFT JOIN building_floor bf ON rn.bldg_floor = bf.building_floor
INNER JOIN (SELECT ec_sensor_lights_id, MAX(CONCAT(ec_lights_date, ' ', ec_lights_time)) AS max_datetime
        FROM ec_param_lights_data
        GROUP BY ec_sensor_lights_id) AS latest 
        ON lght.ec_sensor_lights_id = latest.ec_sensor_lights_id 
AND CONCAT(lght.ec_lights_date, ' ', lght.ec_lights_time) = latest.max_datetime
WHERE eas.ec_arduino_sensors_id IN ('$lghtSensors')
ORDER BY lght.ec_sensor_lights_id ASC
LIMIT $offset, $rows_per_page";

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
WHERE eas.ec_arduino_sensors_id IN ('$utlSensors')
ORDER BY utl.ec_sensor_util_id ASC
LIMIT $offset, $rows_per_page";


    $result_table = mysqli_query($con, $sql);

    while ($row = mysqli_fetch_assoc($result_table)){
        echo "<tr>";
        echo "<td>" . ($row['building_floor'] !== null && $row['building_floor'] !== '' ? $row['building_floor'] . "" : "N/A") . "</td>";
        echo "<td>" . ($row['acu_current'] !== null && $row['acu_current'] !== '' ? $row['acu_current'] . " amps" : "N/A") . "</td>";
        echo "<td>" . ($row['lighting_current'] !== null && $row['lighting_current'] !== '' ? $row['lighting_current'] . " amps" : "N/A") . "</td>";        
        echo "<td>" . ($row['outlet_current'] !== null && $row['outlet_current'] !== '' ? $row['outlet_current'] . " amps" : "N/A") . "</td>";
        echo "<td>" . ($row['utilities_current'] !== null && $row['utilities_current'] !== '' ? $row['utilities_current'] . " A" : "N/A") . "</td>";
        echo "<td>" . ($row['others_current'] !== null && $row['others_current'] !== '' ? $row['others_current'] . " amps" : "N/A") . "</td>";
        echo "</tr>";
    }
    
?>