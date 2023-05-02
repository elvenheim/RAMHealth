<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>

</script>

<?php 
    require_once('energy_technician_connect.php');
    
    $rows_per_page = 10;

    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

    $offset = ($page - 1) * $rows_per_page;

    $count_query = "SELECT COUNT(*) as count FROM energy_consumption";
    $count_result = mysqli_query($con, $count_query);
    $count_row = mysqli_fetch_assoc($count_result);
    $total_rows = $count_row['count'];

    $total_pages = ceil($total_rows / $rows_per_page);

    $sql = "SELECT * FROM energy_consumption ORDER BY energy_consume_id 
            LIMIT $offset, $rows_per_page";
    $result_table = mysqli_query($con, $sql);

    while ($row = mysqli_fetch_assoc($result_table)){
        echo "<tr>";
        echo "<td>" . $row['ec_room_num'] . "</td>";
        echo "<td>" . $row['ec_sensor_id'] . "</td>";
        echo "<td>" . $row['energy_date'] . "</td>";
        echo "<td>" . $row['energy_time'] . "</td>";
        echo "<td>" . $row['energy_current'] . "</td>";
        echo "</tr>";
    }
    
    echo "<div class='pagination-parameter'>";
    if ($total_pages > 1) {
        $start_page = max(1, $page - 2);
        $end_page = min($total_pages, $start_page + 4);
        if ($end_page - $start_page < 4 && $start_page > 1) {
            $start_page = max(1, $end_page - 4);
        }
        echo "<a href='?page=" . max(1, $page - 1) . "'" . 
            ($page == 1 ? "class='disabled'" : "") . ">Prev</a>";
        for ($i = $start_page; $i <= $end_page; $i++) {
            echo "<a href='?page=$i'" . ($page == $i ? " class='active'" : "") . ">$i</a>";
        }
        echo "<a href='?page=" . min($total_pages, $page + 1) . "'" . 
            ($page == $total_pages ? " class='disabled'" : "") . ">Next</a>";
    }
    echo "</div>";

?>