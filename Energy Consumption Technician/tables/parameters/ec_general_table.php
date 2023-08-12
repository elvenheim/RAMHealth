<?php     
    require_once('energy_technician_connect.php');
    
    if (isset($_POST['submit']) && isset($_POST['room_number'])) {
        $selectedSensors = $_POST['room_number'];

        $acuSensors = implode("','", $selectedSensors);

        $rows_per_page = 10;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $rows_per_page;
    
        $count_query = "SELECT COUNT(*) as count FROM ec_param_acu_data";
        $count_result = mysqli_query($con, $count_query);
        $count_row = mysqli_fetch_assoc($count_result);
        $total_rows = $count_row['count'];
    
        $total_pages = ceil($total_rows / $rows_per_page);
    
        $sql = "SELECT acu.*, eas.arduino_bldg_floor, eas.arduino_room_num, bf.bldg_floor_name, st.sensor_type_name
                FROM ec_param_acu_data acu
                JOIN ec_arduino_sensors eas ON acu.ec_sensor_acu_id = eas.ec_arduino_sensors_id
                LEFT JOIN room_number rn ON eas.arduino_room_num = rn.room_num
                LEFT JOIN sensor_type st ON eas.ec_arduino_sensors_type = st.sensor_type_id
                LEFT JOIN building_floor bf ON rn.bldg_floor = bf.building_floor
                INNER JOIN (SELECT ec_sensor_acu_id, MAX(CONCAT(ec_acu_date, ' ', ec_acu_time)) AS max_datetime
                        FROM ec_param_acu_data
                        GROUP BY ec_sensor_acu_id) AS latest 
                        ON acu.ec_sensor_acu_id = latest.ec_sensor_acu_id 
                AND CONCAT(acu.ec_acu_date, ' ', acu.ec_acu_time) = latest.max_datetime
                WHERE eas.arduino_room_num IN ('$acuSensors')
                ORDER BY acu.ec_sensor_acu_id ASC
                LIMIT $offset, $rows_per_page";
    
        $result_table = mysqli_query($con, $sql);
    
        if (!$result_table) {
            echo "Error: " . mysqli_error($con);
        }
        
        if (mysqli_num_rows($result_table) == 0) {
        } else {
            while ($row = mysqli_fetch_assoc($result_table)){
                echo "<tr>";
                echo "<td>" . $row['bldg_floor_name'] . "</td>";
                echo "<td>" . $row['ec_sensor_acu_id'] . "</td>";
                echo "<td>" . $row['arduino_room_num'] . "</td>";
                echo "<td>" . $row['sensor_type_name'] . "</td>";
                echo "<td>" . $row['ec_acu_current']  . ' amps' . "</td>";
                echo "</tr>";
            }
        }
    }
?>

<?php     
    require_once('energy_technician_connect.php');
    
    if (isset($_POST['submit']) && isset($_POST['room_number'])) {
        $selectedSensors = $_POST['room_number'];

        $lghtSensors = implode("','", $selectedSensors);

        $rows_per_page = 10;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $rows_per_page;
    
        $count_query = "SELECT COUNT(*) as count FROM ec_param_lights_data";
        $count_result = mysqli_query($con, $count_query);
        $count_row = mysqli_fetch_assoc($count_result);
        $total_rows = $count_row['count'];
    
        $total_pages = ceil($total_rows / $rows_per_page);
    
        $sql = "SELECT lght.*, eas.arduino_bldg_floor, eas.arduino_room_num, bf.bldg_floor_name, st.sensor_type_name
                FROM ec_param_lights_data lght
                JOIN ec_arduino_sensors eas ON lght.ec_sensor_lights_id = eas.ec_arduino_sensors_id
                LEFT JOIN room_number rn ON eas.arduino_room_num = rn.room_num
                LEFT JOIN sensor_type st ON eas.ec_arduino_sensors_type = st.sensor_type_id
                LEFT JOIN building_floor bf ON rn.bldg_floor = bf.building_floor
                INNER JOIN (SELECT ec_sensor_lights_id, MAX(CONCAT(ec_lights_date, ' ', ec_lights_time)) AS max_datetime
                        FROM ec_param_lights_data
                        GROUP BY ec_sensor_lights_id) AS latest 
                        ON lght.ec_sensor_lights_id = latest.ec_sensor_lights_id 
                AND CONCAT(lght.ec_lights_date, ' ', lght.ec_lights_time) = latest.max_datetime
                WHERE eas.arduino_room_num IN ('$lghtSensors')
                ORDER BY lght.ec_sensor_lights_id ASC
                LIMIT $offset, $rows_per_page";
    
        $result_table = mysqli_query($con, $sql);
    
        if (!$result_table) {
            echo "Error: " . mysqli_error($con);
        }
        if (mysqli_num_rows($result_table) == 0) {
        } else {
            while ($row = mysqli_fetch_assoc($result_table)){
                echo "<tr>";
                echo "<td>" . $row['bldg_floor_name'] . "</td>";
                echo "<td>" . $row['ec_sensor_lights_id'] . "</td>";
                echo "<td>" . $row['arduino_room_num'] . "</td>";
                echo "<td>" . $row['sensor_type_name'] . "</td>";
                echo "<td>" . $row['ec_lights_current']  . ' amps' . "</td>";
                echo "</tr>";
            }   
        }
    }
?>

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
    
        $sql = "SELECT oth.*, eas.arduino_bldg_floor, eas.arduino_room_num, bf.bldg_floor_name, st.sensor_type_name
                FROM ec_param_others_data oth
                JOIN ec_arduino_sensors eas ON oth.ec_sensor_others_id = eas.ec_arduino_sensors_id
                LEFT JOIN room_number rn ON eas.arduino_room_num = rn.room_num
                LEFT JOIN sensor_type st ON eas.ec_arduino_sensors_type = st.sensor_type_id
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
        } else {
            while ($row = mysqli_fetch_assoc($result_table)){
                echo "<tr>";
                echo "<td>" . $row['bldg_floor_name'] . "</td>";
                echo "<td>" . $row['ec_sensor_others_id'] . "</td>";
                echo "<td>" . $row['arduino_room_num'] . "</td>";
                echo "<td>" . $row['sensor_type_name'] . "</td>";
                echo "<td>" . $row['ec_others_current']  . ' amps' . "</td>";
                echo "</tr>";
            }   
        }
    }
?>

<?php     
    require_once('energy_technician_connect.php');
    
    if (isset($_POST['submit']) && isset($_POST['room_number'])) {
        $selectedSensors = $_POST['room_number'];

        $outlSensors = implode("','", $selectedSensors);

        $rows_per_page = 10;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $rows_per_page;
    
        $count_query = "SELECT COUNT(*) as count FROM ec_param_outlet_data";
        $count_result = mysqli_query($con, $count_query);
        $count_row = mysqli_fetch_assoc($count_result);
        $total_rows = $count_row['count'];
    
        $total_pages = ceil($total_rows / $rows_per_page);
    
        $sql = "SELECT outl.*, eas.arduino_bldg_floor, eas.arduino_room_num, bf.bldg_floor_name, st.sensor_type_name
                FROM ec_param_outlet_data outl
                JOIN ec_arduino_sensors eas ON outl.ec_sensor_outlet_id = eas.ec_arduino_sensors_id
                LEFT JOIN room_number rn ON eas.arduino_room_num = rn.room_num
                LEFT JOIN sensor_type st ON eas.ec_arduino_sensors_type = st.sensor_type_id
                LEFT JOIN building_floor bf ON rn.bldg_floor = bf.building_floor
                INNER JOIN (SELECT ec_sensor_outlet_id, MAX(CONCAT(ec_outlet_date, ' ', ec_outlet_time)) AS max_datetime
                        FROM ec_param_outlet_data
                        GROUP BY ec_sensor_outlet_id) AS latest 
                        ON outl.ec_sensor_outlet_id = latest.ec_sensor_outlet_id 
                AND CONCAT(outl.ec_outlet_date, ' ', outl.ec_outlet_time) = latest.max_datetime
                WHERE eas.arduino_room_num IN ('$outlSensors')
                ORDER BY outl.ec_sensor_outlet_id ASC
                LIMIT $offset, $rows_per_page";
    
        $result_table = mysqli_query($con, $sql);
    
        if (!$result_table) {
            echo "Error: " . mysqli_error($con);
        }
        if (mysqli_num_rows($result_table) == 0) {
        } else {
            while ($row = mysqli_fetch_assoc($result_table)){
                echo "<tr>";
                echo "<td>" . $row['bldg_floor_name'] . "</td>";
                echo "<td>" . $row['ec_sensor_outlet_id'] . "</td>";
                echo "<td>" . $row['arduino_room_num'] . "</td>";
                echo "<td>" . $row['sensor_type_name'] . "</td>";
                echo "<td>" . $row['ec_outlet_current']  . ' amps' . "</td>";
                echo "</tr>";
            }   
        }
    }
?>

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
    
        $sql = "SELECT utl.*, eas.arduino_bldg_floor, eas.arduino_room_num, bf.bldg_floor_name, st.sensor_type_name
                FROM ec_param_util_data utl
                JOIN ec_arduino_sensors eas ON utl.ec_sensor_util_id = eas.ec_arduino_sensors_id
                LEFT JOIN room_number rn ON eas.arduino_room_num = rn.room_num
                LEFT JOIN sensor_type st ON eas.ec_arduino_sensors_type = st.sensor_type_id
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
        } else {
            while ($row = mysqli_fetch_assoc($result_table)){
                echo "<tr>";
                echo "<td>" . $row['bldg_floor_name'] . "</td>";
                echo "<td>" . $row['ec_sensor_util_id'] . "</td>";
                echo "<td>" . $row['arduino_room_num'] . "</td>";
                echo "<td>" . $row['sensor_type_name'] . "</td>";
                echo "<td>" . $row['ec_util_current']  . ' amps' . "</td>";
                echo "</tr>";
            }   
        }
    }
?>
