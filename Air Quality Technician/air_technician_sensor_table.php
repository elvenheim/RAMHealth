<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('select[name="sensor_status"]').change(function() {
            var form = $(this).parent('form');
            var formData = form.serialize();
            var originalStatus = $(this).data('original-status');
            if (confirm("Are you sure you want to update the sensor status?")) {
            $.ajax({
                url: 'aq_sensor_status.php',
                type: 'POST',
                data: formData,
                success: function(response) {
                if (response.status === 'success') {
                    var statusSelect = form.find('select[name="sensor_status"]');
                    if (response.sensor_status == 1) {
                    statusSelect.css('background-color', '#646467');
                    } else {
                    statusSelect.css('background-color', '#ccc');
                    }
                    statusSelect.data('original-status', response.sensor_status);
                }
                location.reload();
                },
                error: function(xhr, status, error) {
                console.log('Error: ' + error);
                }
            });
            } else {
            location.reload();
            }
        });
    });

    function deleteRow(sensorID) {
        if (confirm("Are you sure you want to delete this sensor?")) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "air_technician_delete_sensor.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    alert("Sensor has been successfully deleted.");
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

    $count_query = "SELECT COUNT(*) as count FROM sensor";
    $count_result = mysqli_query($con, $count_query);
    $count_row = mysqli_fetch_assoc($count_result);
    $total_rows = $count_row['count'];

    $total_pages = ceil($total_rows / $rows_per_page);

    $sql = "SELECT sensor.*, sensor_type.sensor_type_name 
        FROM sensor
        INNER JOIN sensor_type ON sensor.sensor_type = sensor_type.sensor_type_id
        WHERE sensor_type = '1'
        ORDER BY sensor.sensor_id
        LIMIT $offset, $rows_per_page";
    $result_table = mysqli_query($con, $sql);

    while ($row = mysqli_fetch_assoc($result_table)){
        echo "<tr>";
        echo '<td class="delete-button-row">';
        echo '<button class="delete-button" type="button" onclick="deleteRow(' . $row['sensor_id'] . ')"> 
            <i class="fas fa-trash"></i> 
            </button>';
        echo "</td>";
        echo "<td>" . $row['sensor_room_num'] . "</td>";
        echo "<td>" . $row['sensor_name'] . "</td>";
        echo "<td>" . $row['sensor_type_name'] . "</td>";
        echo "<td>" . $row['sensor_added_at'] . "</td>";
        echo "<td>";
        echo '<form class="status-form">';
        echo '<input type="hidden" name="sensor_id" value="' . $row['sensor_id'] . '">';
        echo '<select name="sensor_status" onchange="updateStatus(this.form);">';
        echo '<option value="1"' . ($row['sensor_status'] == 1 ? ' selected' : '') . '>Enabled</option>';
        echo '<option value="0"' . ($row['sensor_status'] == 0 ? ' selected' : '') . '>Disabled</option>';
        echo '</select>';
        echo '</form>';
        echo "</td>";
        echo "</tr>";
    }

    // $sql = "SELECT * FROM sensor WHERE sensor_type ='1' ORDER BY sensor_id LIMIT $offset, $rows_per_page";
    // $result_table = mysqli_query($con, $sql);

    // while ($row = mysqli_fetch_assoc($result_table)){
    //     echo "<tr>";
    //     echo '<td class="delete-button-row">';
    //     echo '<button class="delete-button" type="button" onclick="deleteRow(' . $row['sensor_id'] . ')"> 
    //         <i class="fas fa-trash"></i> 
    //         </button>';
    //     echo "</td>";
    //     echo "<td>" . $row['sensor_id'] . "</td>";
    //     echo "<td>" . $row['sensor_room_num'] . "</td>";
    //     echo "<td>" . $row['sensor_type'] . "</td>";
    //     echo "<td>" . $row['sensor_name'] . "</td>";
    //     echo "<td>" . $row['sensor_added_at'] . "</td>";
    //     echo "<td>";
    //     echo '<form class="status-form">';
    //     echo '<input type="hidden" name="user_id" value="' . $row['sensor_id'] . '">';
    //     echo '<select name="sensor_status" onchange="updateStatus(this.form);">';
    //     echo '<option value="1"' . ($row['sensor_status'] == 1 ? ' selected' : '') . '>Enabled</option>';
    //     echo '<option value="0"' . ($row['sensor_status'] == 0 ? ' selected' : '') . '>Disabled</option>';
    //     echo '</select>';
    //     echo '</form>';
    //     echo "</td>";
    //     // echo "<td>" . $row['sensor_update'] . "</td>";
    //     echo "</tr>";
    // }
        

    echo "<div class='pagination-sensor'>";
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