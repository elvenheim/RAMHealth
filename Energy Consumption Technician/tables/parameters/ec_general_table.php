<?php     
    require_once('energy_technician_connect.php');
    
    $rows_per_page = 10;

    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

    $offset = ($page - 1) * $rows_per_page;

    $count_query = "SELECT COUNT(*) as count FROM energy_consumption_table";
    $count_result = mysqli_query($con, $count_query);
    $count_row = mysqli_fetch_assoc($count_result);
    $total_rows = $count_row['count'];

    $total_pages = ceil($total_rows / $rows_per_page);

    $sql = "SELECT ect.*, bf.building_floor, acu.acu_current, ecl.lighting_current, 
                    ecot.others_current, ecou.outlet_current, util.utilities_current
            FROM energy_consumption_table ect
            LEFT JOIN ec_sensor ecs ON ect.ec_bldg_floor = ecs.ec_sensor_bldg_floor
            LEFT JOIN building_floor bf ON ecs.ec_sensor_bldg_floor = bf.building_floor
            LEFT JOIN ec_acu acu ON ect.ec_acu_data = acu.acu_sensor
            LEFT JOIN ec_lighting ecl ON ect.ec_lighting_data = ecl.lighting_sensor
            LEFT JOIN ec_others ecot ON ect.ec_others_data = ecot.others_sensor
            LEFT JOIN ec_outlet ecou ON ect.ec_outlet_data = ecou.outlet_sensor
            LEFT JOIN ec_utilities util ON ect.ec_utilities_data = util.utilities_sensor
            GROUP BY energy_consume_id
            ORDER BY ec_bldg_floor
            LIMIT $offset, $rows_per_page";

    $result_table = mysqli_query($con, $sql);

    while ($row = mysqli_fetch_assoc($result_table)){
        echo "<tr>";
        echo "<td>" . ($row['building_floor'] !== null && $row['building_floor'] !== '' ? $row['building_floor'] . "" : "N/A") . "</td>";
        echo "<td>" . ($row['acu_current'] !== null && $row['acu_current'] !== '' ? $row['acu_current'] . " A" : "N/A") . "</td>";
        echo "<td>" . ($row['lighting_current'] !== null && $row['lighting_current'] !== '' ? $row['lighting_current'] . " A" : "N/A") . "</td>";        
        echo "<td>" . ($row['outlet_current'] !== null && $row['outlet_current'] !== '' ? $row['outlet_current'] . " A" : "N/A") . "</td>";
        echo "<td>" . ($row['utilities_current'] !== null && $row['utilities_current'] !== '' ? $row['utilities_current'] . " A" : "N/A") . "</td>";
        echo "<td>" . ($row['others_current'] !== null && $row['others_current'] !== '' ? $row['others_current'] . " A" : "N/A") . "</td>";
        echo "</tr>";
    }
    
?>