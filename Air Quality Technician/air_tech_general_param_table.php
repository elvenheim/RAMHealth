<?php     
    require_once('air_technician_connect.php');
    
    $rows_per_page = 10;

    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

    $offset = ($page - 1) * $rows_per_page;

    $count_query = "SELECT COUNT(*) as count FROM air_quality_table";
    $count_result = mysqli_query($con, $count_query);
    $count_row = mysqli_fetch_assoc($count_result);
    $total_rows = $count_row['count'];

    $total_pages = ceil($total_rows / $rows_per_page);

    $sql = "SELECT aqt.*, it.indoor_temp_data, ot.outdoor_temp_data, pm.pm_ten, 
            pm.pm_two_five, pm.pm_zero_one, rh.humidity_level_data, gs.gas_level_data,
            bf.building_floor, rn.room_name
            FROM air_quality_table aqt
            JOIN building_floor bf ON aqt.air_quality_bldg_floor = bf.building_floor
            JOIN room_number rn ON aqt.air_quality_room_num = rn.room_num
            JOIN aq_gas_level gs ON aqt.aq_gas_id = gs.gas_id
            JOIN aq_indoor_temperature it ON aqt.aq_indoor_temp_id = it.indoor_temp_id
            JOIN aq_outdoor_temperature ot ON aqt.aq_outdoor_temp_id = ot.outdoor_temp_id
            JOIN aq_particulate_matter pm ON aqt.aq_pm_id = pm.pm_id
            JOIN aq_relative_humidity rh ON aqt.aq_humidity_id = rh.humidity_id
            ORDER BY air_quality_table_id
            LIMIT $offset, $rows_per_page";

    $result_table = mysqli_query($con, $sql);

    while ($row = mysqli_fetch_assoc($result_table)){
        echo "<tr>";
        echo "<td>" . $row['building_floor'] . "</td>";
        echo "<td>" . $row['room_name'] . "</td>"; 
        echo "<td>" . $row['indoor_temp_data'] . "&deg;C</td>";
        echo "<td>" . $row['outdoor_temp_data'] . "&deg;C</td>";        
        echo "<td>" . $row['pm_ten'] . " &micro;g/m³</td>";
        echo "<td>" . $row['pm_two_five'] . " &micro;g/m³</td>";
        echo "<td>" . $row['pm_zero_one'] . " &micro;g/m³</td>";
        echo "<td>" . $row['gas_level_data']  . " ppm</td>";
        echo "<td>" . $row['humidity_level_data'] . "%</td>";
        echo "</tr>";
    }   
    
    echo "<div class='pagination-general-param'>";
    if ($total_pages > 1) {
        $start_page = max(1, $page - 2);
        $end_page = min($total_pages, $start_page + 4);
        if ($end_page - $start_page < 4 && $start_page > 1) {
            $start_page = max(1, $end_page - 4);
        }
        echo "<a href='?page=" . max(1, $page - 1) . "'" . 
            ($page == 1 ? "class='pagination-general-param-disabled'" : "") . ">Prev</a>";
        for ($i = $start_page; $i <= $end_page; $i++) {
            echo "<a href='?page=$i'" . ($page == $i ? " class='active'" : "") . ">$i</a>";
        }
        echo "<a href='?page=" . min($total_pages, $page + 1) . "'" . 
            ($page == $total_pages ? " class='pagination-general-param-disabled'" : "") . ">Next</a>";
    }
    echo "</div>";
?>