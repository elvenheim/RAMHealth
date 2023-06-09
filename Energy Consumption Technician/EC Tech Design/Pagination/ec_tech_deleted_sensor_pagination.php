<?php 
    require_once('../Energy Consumption Technician/energy_technician_connect.php');
    
    $rows_per_page = 10;

    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

    $offset = ($page - 1) * $rows_per_page;

    $count_query = "SELECT COUNT(*) as count FROM deleted_ec_sensors";
    $count_result = mysqli_query($con, $count_query);
    $count_row = mysqli_fetch_assoc($count_result);
    $total_rows = $count_row['count'];

    $total_pages = ceil($total_rows / $rows_per_page);

    $sql ="SELECT decs.*, epg.ec_panel_grouping_id, epl.ec_panel_label_id, bf.bldg_floor_name, decs.arduino_room_num,
                easl.ec_arduino_sensor_label_id, st.sensor_type_name
        FROM deleted_ec_sensors AS decs
        LEFT JOIN ec_arduino_sensor_linking AS easl ON decs.ec_arduino_sensor_id = easl.ec_arduino_deleted_sensor

        LEFT JOIN ec_panel_grouping epg ON easl.ec_panel_grouping_id = epg.ec_panel_grouping_id 
        LEFT JOIN ec_panel_label epl ON easl.ec_panel_label_id = epl.ec_panel_label_id 
        LEFT JOIN ec_arduino_label_sensor eals ON easl.ec_arduino_sensor_label_id = eals.ec_arduino_sensor_label_id 
        LEFT JOIN ec_arduino_sensors eas ON easl.ec_arduino_sensors_id = eas.ec_arduino_sensors_id

        LEFT JOIN room_number rn ON decs.arduino_bldg_floor = rn.bldg_floor AND decs.arduino_room_num = rn.room_num
        LEFT JOIN building_floor bf ON rn.bldg_floor = bf.building_floor 
        LEFT JOIN sensor_type st ON decs.arduino_sensors_type = st.sensor_type_id
        ORDER BY bf.building_floor ASC
        LIMIT $offset, $rows_per_page";

    $result_table = mysqli_query($con, $sql);

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