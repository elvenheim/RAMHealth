<?php
    require_once('air_technician_connect.php');

    $rows_per_page = 10;
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($page - 1) * $rows_per_page;

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

    $data = array();
    while ($row = mysqli_fetch_assoc($result_table)){
        $data[] = $row;
    }

    $total_rows_result = mysqli_query($con, "SELECT FOUND_ROWS()");
    $total_rows_row = mysqli_fetch_row($total_rows_result);
    $total_rows = $total_rows_row[0];

    $total_pages = ceil($total_rows / $rows_per_page);

    // Now you have the fetched data in the $data array
    // You can use the $data array for further processing or manipulation as needed
    foreach ($data as $row) {
        // Access individual row data using the column names
        $aq_sensor_room_num = $row['aq_sensor_room_num'];
        $pm_sensor = $row['pm_sensor'];
        $aq_sensor_name = $row['aq_sensor_name'];
        $pm_date = $row['pm_date'];
        $pm_time = $row['pm_time'];
        $pm_ten = $row['pm_ten'];
        $pm_two_five = $row['pm_two_five'];
        $pm_zero_one = $row['pm_zero_one'];
        // Perform any desired operations with the data here
    }

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
