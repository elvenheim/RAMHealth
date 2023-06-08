<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
function restoreRow(sensorID) {
    if (confirm("Are you sure you want to restore this sensor?")) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "../Energy Consumption Technician/scripts/deleted sensor table/ec_tech_restore_sensor.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                alert(xhr.responseText);
                window.location.reload();
            }
        };
        xhr.send("sensor_id=" + sensorID);
    }
}
</script>

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
        LIMIT $offset, $rows_per_page";

    $result_table = mysqli_query($con, $sql);

    while ($row = mysqli_fetch_assoc($result_table)){
        echo '<tr data-sensor-id="' . $row['ec_arduino_sensor_id'] . '"' . '>';
        echo "<td>" . $row['ec_panel_grouping_id'] . "</td>";
        echo "<td>" . $row['ec_panel_label_id'] . "</td>";
        echo "<td>" . $row['bldg_floor_name'] . "</td>";
        echo "<td>" . $row['arduino_room_num'] . "</td>";
        echo "<td>" . $row['ec_arduino_sensor_label_id'] . "</td>";
        echo "<td>" . $row['ec_arduino_sensor_id'] . "</td>";
        echo "<td>" . $row['sensor_type_name'] . "</td>";
        echo "<td>" . $row['arduino_sensors_added_at'] . "</td>";
        echo "<td>" . $row['arduino_sensors_deleted_at'] . "</td>";
        echo '<td class="action-buttons">';
        echo '<div>';
        echo '<button class="restore-button" type="button" onclick="restoreRow(\'' . $row['ec_arduino_sensor_id'] . '\')"> 
                <i class="fas fa-rotate-left"></i></button>';
        echo '</div>';
        echo "</td>";
        echo "</tr>";
    }
?>