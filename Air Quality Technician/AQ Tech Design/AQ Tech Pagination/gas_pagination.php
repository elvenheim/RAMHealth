<?php     
    require_once('air_technician_connect.php');
    
    $rows_per_page = 10;
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($page - 1) * $rows_per_page;

    // Query to get the data with pagination
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
        $gas_sensor = $row['gas_sensor'];
        $aq_sensor_name = $row['aq_sensor_name'];
        $gas_date = $row['gas_date'];
        $gas_time = $row['gas_time'];
        $gas_ten = $row['gas_level_data'];
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