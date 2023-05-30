<?php     
    require_once('air_technician_connect.php');
    
    $rows_per_page = 10;

    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

    $offset = ($page - 1) * $rows_per_page;

    $count_query = "SELECT COUNT(*) as count FROM aq_indoor_temperature";
    $count_result = mysqli_query($con, $count_query);
    $count_row = mysqli_fetch_assoc($count_result);
    $total_rows = $count_row['count'];

    $total_pages = ceil($total_rows / $rows_per_page);

    $sql = "SELECT aqit.*, aqs.aq_sensor_room_num, aqs.aq_sensor_name
            FROM aq_indoor_temperature aqit
            JOIN aq_sensor aqs ON aqit.indoor_temp_sensor = aqs.aq_sensor_id
            ORDER BY indoor_temp_sensor 
            LIMIT $offset, $rows_per_page";
    $result_table = mysqli_query($con, $sql);
 
    while ($row = mysqli_fetch_assoc($result_table)){
        echo "<tr>";
        echo "<td>" . $row['aq_sensor_room_num'] . "</td>";
        echo "<td>" . $row['indoor_temp_sensor'] . "</td>";
        echo "<td>" . $row['aq_sensor_name'] . "</td>";
        echo "<td>" . $row['indoor_temp_date'] . "</td>";
        echo "<td>" . $row['indoor_temp_time'] . "</td>";
        echo "<td>" . $row['indoor_temp_data'] . "</td>";
        echo "</tr>";
    }
    
    echo "<div class='pagination-indoor-temperature'>";
    if ($total_pages > 1) {
        $start_page = max(1, $page - 2);
        $end_page = min($total_pages, $start_page + 4);
        if ($end_page - $start_page < 4 && $start_page > 1) {
            $start_page = max(1, $end_page - 4);
        }
        echo "<a href='?page=" . max(1, $page - 1) . "'" . 
            ($page == 1 ? "class='pagination-indoor-temp-disabled'" : "") . ">Prev</a>";
        for ($i = $start_page; $i <= $end_page; $i++) {
            echo "<a href='?page=$i'" . ($page == $i ? " class='active'" : "") . ">$i</a>";
        }
        echo "<a href='?page=" . min($total_pages, $page + 1) . "'" . 
            ($page == $total_pages ? " class='pagination-indoor-temp-disabled'" : "") . ">Next</a>";
    }
    echo "</div>";
?>