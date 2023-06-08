<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
function updateStatus(form) {
    var formData = $(form).serialize();
    var originalStatus = $(form).find('select[name="sensor_status"]').val();

    if (confirm("Are you sure you want to update the sensor status?")) {
        $.ajax({
            url: '../Energy Consumption Technician/scripts/sensor table/ec_sensor_status.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                console.log('Response:', response);
                var parsedResponse;
                try {
                    parsedResponse = JSON.parse(response);
                } catch (error) {
                    console.log('Error parsing JSON:', error);
                }
                if (parsedResponse && parsedResponse.status === 'success') {
                    var statusSelect = $(form).find('select[name="sensor_status"]');
                    if (parsedResponse.arduino_status == 1) {
                        statusSelect.css('background-color', '#646467');
                    } else {
                        statusSelect.css('background-color', '#ccc');
                    }
                    // Update the original status value
                    originalStatus = parsedResponse.arduino_status;
                }
                window.location.reload();
            },
            error: function(xhr, status, error) {
                console.log('Error: ' + error);
            }
        });
    } else {
        window.location.reload();
    }
}

function deleteRow(sensorID) {
    if (confirm("Are you sure you want to delete this sensor?")) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "../Energy Consumption Technician/scripts/deleted sensor table/ec_tech_delete_sensor.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onload = function() {
            if (xhr.status === 200) {
                console.log("Deleted sensor ID: " + sensorID);
                alert("Sensor has been successfully deleted.");
                removeRow(sensorID); // Remove the deleted row from the table
                // window.location.reload();
            }
        };
        xhr.send("sensor_id=" + sensorID);
    }
}

function removeRow(sensorID) {
    var row = document.querySelector('tr[data-sensor-id="' + sensorID + '"]');
    if (row) {
        row.remove();
    }
}


function editRow(ECsensorId) {
    if (confirm("Do you want to edit this sensor?")){
        var form = document.createElement("form");
        form.setAttribute("method", "post");
        form.setAttribute("action", "../Energy Consumption Technician/scripts/sensor table/fetch_ec_sensor_details.php"); // Replace with your edit page URL

        // Create a hidden input field to pass the employee ID
        var input = document.createElement("input");
        input.setAttribute("type", "hidden");
        input.setAttribute("name", "ec_arduino_sensors_id"); //edit
        input.setAttribute("value", ECsensorId);

        // Append the input field to the form
        form.appendChild(input);

        // Append the form to the document body
        document.body.appendChild(form);

        // Submit the form
        form.submit();
    }
}
</script>

<?php 
    require_once('../Energy Consumption Technician/energy_technician_connect.php');
    
    $rows_per_page = 10;

    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

    $offset = ($page - 1) * $rows_per_page;

    $count_query = "SELECT COUNT(*) as count FROM ec_arduino_sensors";
    $count_result = mysqli_query($con, $count_query);
    $count_row = mysqli_fetch_assoc($count_result);
    $total_rows = $count_row['count'];

    $total_pages = ceil($total_rows / $rows_per_page);

    $sql = "SELECT easl.*, epg.ec_panel_grouping_id, epl.ec_panel_label_id, eas.arduino_bldg_floor, 
            eas.arduino_room_num, st.sensor_type_name, eas.arduino_sensors_status, eas.ec_arduino_sensors_id,
            eas.arduino_sensors_added_at, eals.ec_arduino_sensor_label_id, bf.bldg_floor_name
        FROM ec_arduino_sensor_linking easl
        INNER JOIN ec_arduino_sensors eas ON easl.ec_arduino_sensors_id = eas.ec_arduino_sensors_id
        LEFT JOIN ec_panel_grouping epg ON easl.ec_panel_grouping_id = epg.ec_panel_grouping_id 
        LEFT JOIN ec_panel_label epl ON easl.ec_panel_label_id = epl.ec_panel_label_id 
        LEFT JOIN ec_arduino_label_sensor eals ON easl.ec_arduino_sensor_label_id = eals.ec_arduino_sensor_label_id 
        LEFT JOIN deleted_ec_sensors decs ON easl.ec_arduino_deleted_sensor = decs.ec_arduino_sensor_id
        LEFT JOIN room_number rn ON eas.arduino_bldg_floor = rn.bldg_floor AND eas.arduino_room_num = rn.room_num
        LEFT JOIN building_floor bf ON rn.bldg_floor = bf.building_floor
        LEFT JOIN sensor_type st ON eas.ec_arduino_sensors_type = st.sensor_type_id
        LIMIT $offset, $rows_per_page";

    $result_table = mysqli_query($con, $sql);

    while ($row = mysqli_fetch_assoc($result_table)){
        echo '<tr data-sensor-id="' . $row['ec_arduino_sensors_id'] . '"' . 
        ($row['arduino_sensors_status'] == 0 ? ' class="disabled"' : '') . '>';
        echo "<td>" . $row['ec_panel_grouping_id'] . "</td>";
        echo "<td>" . $row['ec_panel_label_id'] . "</td>";
        echo "<td>" . $row['bldg_floor_name'] . "</td>";
        echo "<td>" . $row['arduino_room_num'] . "</td>";
        echo "<td>" . $row['ec_arduino_sensor_label_id'] . "</td>";
        echo "<td>" . $row['ec_arduino_sensors_id'] . "</td>";
        echo "<td>" . $row['sensor_type_name'] . "</td>";
        echo "<td>" . $row['arduino_sensors_added_at'] . "</td>";
        echo "<td>";
        echo '<form class="status-form">';
        echo '<input type="hidden" name="ec_arduino_sensors_id" value="' . $row['ec_arduino_sensors_id'] . '">';
        echo '<select name="sensor_status" onchange="updateStatus(this.form);">';
        echo '<option class="status-enabled" value="1"' . ($row['arduino_sensors_status'] == 1 ? ' selected' : '') . '>Enabled</option>';
        echo '<option class="status-disabled" value="0"' . ($row['arduino_sensors_status'] == 0 ? ' selected' : '') . '>Disabled</option>';
        echo '</select>';
        echo '</form>';
        echo "</td>";
        echo '<td class="action-buttons">';
        echo '<div>';
        echo '<button class="edit-button" type="button" onclick="editRow(\'' . $row['ec_arduino_sensors_id'] . '\')"> 
        <i class="fas fa-edit"></i></button>';
        echo '<button class="delete-button" type="button" onclick="deleteRow(\'' . $row['ec_arduino_sensors_id'] . '\')"> 
        <i class="fas fa-trash"></i>
        </button>';
        echo '</div>';
        echo "</td>";
        echo "</tr>";
    }
?>