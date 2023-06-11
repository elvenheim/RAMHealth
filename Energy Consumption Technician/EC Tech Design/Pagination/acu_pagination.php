<?php   
    require_once('energy_technician_connect.php');

    $rows_per_page = 10;
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($page - 1) * $rows_per_page;

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
            ORDER BY acu.ec_sensor_acu_id ASC
            LIMIT $offset, $rows_per_page";
    $result_table = mysqli_query($con, $sql);
    
    $total_rows_result = mysqli_query($con, "SELECT FOUND_ROWS()");
    $total_rows_row = mysqli_fetch_row($total_rows_result);
    $total_rows = $total_rows_row[0];
    $total_pages = ceil($total_rows / $rows_per_page);
    
    echo "<div class='pagination'>";
    if ($total_pages > 1) {
        $start_page = max(1, $page - 2);
        $end_page = min($total_pages, $start_page + 4);
        if ($end_page - $start_page < 4 && $start_page > 1) {
            $start_page = max(1, $end_page - 4);
        }
    
        $sortParam = isset($_GET['sort']) ? "&sort=" . $_GET['sort'] : "";
    
        if ($page == 1) {
            echo "<span class='pagination-disabled'>Prev</span>";
        } else {
            echo "<a href='?page=" . ($page - 1) . "$sortParam'>Prev</a>";
        }
    
        for ($i = $start_page; $i <= $end_page; $i++) {
            echo "<a href='?page=$i$sortParam'" . ($page == $i ? " class='active'" : "") . ">$i</a>";
        }
    
        if ($page == $total_pages) {
            echo "<span class='pagination-disabled'>Next</span>";
        } else {
            echo "<a href='?page=" . ($page + 1) . "$sortParam'>Next</a>";
        }
    }
    echo "</div>"; 
?>