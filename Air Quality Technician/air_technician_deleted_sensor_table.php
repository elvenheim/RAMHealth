<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
function restoreRow(sensorID) {
    if (confirm("Are you sure you want to restore this sensor?")) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "air_technician_restore_sensor.php", true);
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
    require_once('air_technician_connect.php');
    
    $rows_per_page = 10;

    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

    $offset = ($page - 1) * $rows_per_page;

    $count_query = "SELECT COUNT(*) as count FROM deleted_aq_sensors";
    $count_result = mysqli_query($con, $count_query);
    $count_row = mysqli_fetch_assoc($count_result);
    $total_rows = $count_row['count'];

    $total_pages = ceil($total_rows / $rows_per_page);

    $sql = "SELECT daq.*, st.sensor_type_name, rn.room_num, rn.bldg_floor
            FROM deleted_aq_sensors daq
            LEFT JOIN room_number rn ON daq.deleted_aq_sensor_room_num = rn.room_num
            LEFT JOIN sensor_type st ON daq.deleted_aq_sensor_type_id = st.sensor_type_id
            GROUP BY daq.deleted_aq_sensor_id
            ORDER BY rn.bldg_floor DESC
            LIMIT $offset, $rows_per_page";
            
    $result_table = mysqli_query($con, $sql);

    while ($row = mysqli_fetch_assoc($result_table)){
        echo "<tr>";
        echo "<td>" . $row['bldg_floor'] . "</td>";
        echo "<td>" . $row['room_num'] . "</td>";
        echo "<td>" . $row['deleted_aq_sensor_id'] . "</td>";
        echo "<td>" . $row['deleted_aq_sensor_name'] . "</td>";
        echo "<td>" . $row['sensor_type_name'] . "</td>";
        echo "<td>" . $row['deleted_aq_sensor_add_at'] . "</td>";
        echo "<td>" . $row['deleted_aq_sensor_deleted_at'] . "</td>";
        echo '<td class="action-buttons">';
        echo '<div>';
        echo '<button class="restore-button" type="button" onclick="restoreRow(\'' . $row['deleted_aq_sensor_id'] . '\')"> 
                <i class="fas fa-rotate-left"></i></button>';
        echo '</div>';
        echo "</td>"; 
        echo "</tr>";
    }
?>