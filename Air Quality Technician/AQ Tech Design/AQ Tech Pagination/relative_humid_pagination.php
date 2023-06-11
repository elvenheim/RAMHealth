<?php
    require_once('air_technician_connect.php');

    $rows_per_page = 10;
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($page - 1) * $rows_per_page;

    $sql = "SELECT SQL_CALC_FOUND_ROWS aqrm.*, aqs.aq_sensor_room_num, aqs.aq_sensor_name
            FROM aq_relative_humidity aqrm
            INNER JOIN (
                SELECT humidity_sensor, MAX(CONCAT(humidity_date, ' ', humidity_time)) AS max_datetime
                FROM aq_relative_humidity
                GROUP BY humidity_sensor
            ) AS latest ON aqrm.humidity_sensor = latest.humidity_sensor AND CONCAT(aqrm.humidity_date, ' ', aqrm.humidity_time) = latest.max_datetime
            JOIN aq_sensor aqs ON aqrm.humidity_sensor = aqs.aq_sensor_id
            ORDER BY aqs.aq_sensor_room_num ASC
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