<?php     
    require_once('air_technician_connect.php');
    
    $rows_per_page = 10;
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($page - 1) * $rows_per_page;

    // Query to get the data with pagination
    $sql = "SELECT SQL_CALC_FOUND_ROWS aqpm.*, aqs.aq_sensor_room_num, aqs.aq_sensor_name
            FROM aq_particulate_matter aqpm
            JOIN aq_sensor aqs ON aqpm.pm_sensor = aqs.aq_sensor_id
            INNER JOIN (
                SELECT pm_sensor, MAX(CONCAT(pm_date, ' ', pm_time)) AS max_datetime
                FROM aq_particulate_matter
                GROUP BY pm_sensor
            ) AS latest ON aqpm.pm_sensor = latest.pm_sensor AND CONCAT(aqpm.pm_date, ' ', aqpm.pm_time) = latest.max_datetime
            ORDER BY aqs.aq_sensor_room_num ASC
            LIMIT $offset, $rows_per_page";

    $result_table = mysqli_query($con, $sql);

    while ($row = mysqli_fetch_assoc($result_table)){
        echo "<tr>";
        echo "<td>" . $row['aq_sensor_room_num'] . "</td>";
        echo "<td>" . $row['pm_sensor'] . "</td>";
        echo "<td>" . $row['aq_sensor_name'] . "</td>";
        echo "<td>" . $row['pm_date'] . "</td>";
        echo "<td>" . $row['pm_time'] . "</td>";
        echo "<td>" . $row['pm_ten'] . "</td>";
        echo "<td>" . $row['pm_two_five'] . "</td>";
        echo "<td>" . $row['pm_zero_one'] . "</td>";
        echo "</tr>";
    }

    // Get the total count of rows (without pagination)
    $total_rows_result = mysqli_query($con, "SELECT FOUND_ROWS()");
    $total_rows_row = mysqli_fetch_row($total_rows_result);
    $total_rows = $total_rows_row[0];

    $total_pages = ceil($total_rows / $rows_per_page);
?>