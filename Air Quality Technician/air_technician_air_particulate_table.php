<?php     
    require_once('air_technician_connect.php');
    
    $rows_per_page = 10;

    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

    $offset = ($page - 1) * $rows_per_page;

    $count_query = "SELECT COUNT(*) as count FROM aq_particulate_matter";
    $count_result = mysqli_query($con, $count_query);
    $count_row = mysqli_fetch_assoc($count_result);
    $total_rows = $count_row['count'];

    $total_pages = ceil($total_rows / $rows_per_page);

    $sql = "SELECT aqpm.*, aqs.aq_sensor_room_num, aqs.aq_sensor_name 
            FROM aq_particulate_matter aqpm
            JOIN aq_sensor aqs ON aqpm.pm_sensor = aqs.aq_sensor_id
            ORDER BY pm_id 
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
?>