<?php     
    require_once('air_technician_connect.php');
    
    $rows_per_page = 10;
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($page - 1) * $rows_per_page;

    $sql = "SELECT SQL_CALC_FOUND_ROWS aqg.*, aqs.aq_sensor_room_num, aqs.aq_sensor_name
            FROM aq_gas_level aqg
            INNER JOIN (
                SELECT gas_sensor, MAX(CONCAT(gas_date, ' ', gas_time)) AS max_datetime
                FROM aq_gas_level
                GROUP BY gas_sensor
            ) AS latest ON aqg.gas_sensor = latest.gas_sensor AND CONCAT(aqg.gas_date, ' ', aqg.gas_time) = latest.max_datetime
            JOIN aq_sensor aqs ON aqg.gas_sensor = aqs.aq_sensor_id
            ORDER BY aqs.aq_sensor_room_num ASC
            LIMIT $offset, $rows_per_page";
            
    $result_table = mysqli_query($con, $sql);

    while ($row = mysqli_fetch_assoc($result_table)){
        echo "<tr>";
        echo "<td>" . $row['aq_sensor_room_num'] . "</td>";
        echo "<td>" . $row['gas_sensor'] . "</td>";
        echo "<td>" . $row['aq_sensor_name'] . "</td>";
        echo "<td>" . $row['gas_date'] . "</td>";
        echo "<td>" . $row['gas_time'] . "</td>";
        echo "<td>" . $row['gas_level_data']  . ' ppm' . "</td>";
        echo "</tr>";
    }

    $total_rows_result = mysqli_query($con, "SELECT FOUND_ROWS()");
    $total_rows_row = mysqli_fetch_row($total_rows_result);
    $total_rows = $total_rows_row[0];

    $total_pages = ceil($total_rows / $rows_per_page);
?>