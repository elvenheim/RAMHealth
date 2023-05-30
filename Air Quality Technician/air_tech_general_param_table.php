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

    $sql = "SELECT aqt.*, rn.bldg_floor, it.indoor_temp_data, ot.outdoor_temp_data, pm.pm_ten, 
            pm.pm_two_five, pm.pm_zero_one, rh.humidity_level_data, gs.gas_level_data
            FROM air_quality_table aqt
            LEFT JOIN aq_sensor aqs ON aqt.air_quality_room_num = aqs.aq_sensor_room_num
            LEFT JOIN room_number rn ON aqs.aq_sensor_room_num = rn.room_num
            LEFT JOIN building_floor bf ON bf.building_floor = rn.bldg_floor
            LEFT JOIN aq_gas_level gs ON aqt.aq_gas_id = gs.gas_sensor
            LEFT JOIN aq_indoor_temperature it ON aqt.aq_indoor_temp_id = it.indoor_temp_sensor
            LEFT JOIN aq_outdoor_temperature ot ON aqt.aq_outdoor_temp_id = ot.outdoor_temp_sensor
            LEFT JOIN aq_particulate_matter pm ON aqt.aq_pm_id = pm.pm_sensor
            LEFT JOIN aq_relative_humidity rh ON aqt.aq_humidity_id = rh.humidity_sensor
            GROUP BY air_quality_table_id
            ORDER BY air_quality_room_num
            LIMIT $offset, $rows_per_page";

    $result_table = mysqli_query($con, $sql);

    while ($row = mysqli_fetch_assoc($result_table)){
        echo "<tr>";
        echo "<td>" . $row['bldg_floor'] . "</td>";
        echo "<td>" . $row['air_quality_room_num'] . "</td>"; 
        echo "<td>" . ($row['indoor_temp_data'] !== null && $row['indoor_temp_data'] !== '' ? $row['indoor_temp_data'] . "&deg;C" : "N/A") . "</td>";
        echo "<td>" . ($row['outdoor_temp_data'] !== null && $row['outdoor_temp_data'] !== '' ? $row['outdoor_temp_data'] . "&deg;C" : "N/A") . "</td>";        
        echo "<td>" . ($row['pm_ten'] !== null && $row['pm_ten'] !== '' ? $row['pm_ten'] . " &micro;g/m³" : "N/A") . "</td>";
        echo "<td>" . ($row['pm_two_five'] !== null && $row['pm_two_five'] !== '' ? $row['pm_two_five'] . " &micro;g/m³" : "N/A") . "</td>";
        echo "<td>" . ($row['pm_zero_one'] !== null && $row['pm_zero_one'] !== '' ? $row['pm_zero_one'] . " &micro;g/m³" : "N/A") . "</td>";
        echo "<td>" . ($row['gas_level_data'] !== null && $row['gas_level_data'] !== '' ? $row['gas_level_data'] . " ppm" : "N/A") . "</td>";
        echo "<td>" . ($row['humidity_level_data'] !== null && $row['humidity_level_data'] !== '' ? $row['humidity_level_data'] . "%" : "N/A") . "</td>";
        echo "</tr>";
    }
?>