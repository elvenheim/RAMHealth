<?php     
    require_once('energy_technician_connect.php');
    
    $rows_per_page = 10;

    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

    $offset = ($page - 1) * $rows_per_page;

    $count_query = "SELECT COUNT(*) as count FROM ec_outlet";
    $count_result = mysqli_query($con, $count_query);
    $count_row = mysqli_fetch_assoc($count_result);
    $total_rows = $count_row['count'];

    $total_pages = ceil($total_rows / $rows_per_page);

    $sql = "SELECT ac.*, ecs.ec_sensor_bldg_floor, ecs.ec_sensor_name
            FROM ec_outlet ac
            JOIN ec_sensor ecs ON ac.outlet_sensor = ecs.ec_sensor_id
            ORDER BY outlet_sensor
            LIMIT $offset, $rows_per_page";
    $result_table = mysqli_query($con, $sql);

    while ($row = mysqli_fetch_assoc($result_table)){
        echo "<tr>";
        echo "<td>" . $row['ec_sensor_bldg_floor'] . "</td>";
        echo "<td>" . $row['outlet_sensor'] . "</td>";
        echo "<td>" . $row['ec_sensor_name'] . "</td>";
        echo "<td>" . $row['outlet_date'] . "</td>";
        echo "<td>" . $row['outlet_date'] . "</td>";
        echo "<td>" . $row['outlet_current']  . ' A' . "</td>";
        echo "</tr>";
    }   
?>