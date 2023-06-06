<?php     
    require_once('air_technician_connect.php');
    
    if (isset($_POST['submit']) && isset($_POST['room_number'])) {
        // Retrieve the selected room numbers
        $selectedRooms = $_POST['room_number'];

        // Construct the SQL query to fetch the data for the selected rooms
        $roomNumbers = implode("','", $selectedRooms);

        $rows_per_page = 10;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $rows_per_page;

        $sql = "SELECT SQL_CALC_FOUND_ROWS aqrm.*, aqs.aq_sensor_room_num, aqs.aq_sensor_name
                FROM aq_relative_humidity aqrm
                JOIN aq_sensor aqs ON aqrm.humidity_sensor = aqs.aq_sensor_id
                INNER JOIN (
                    SELECT humidity_sensor, MAX(CONCAT(humidity_date, ' ', humidity_time)) AS max_datetime
                    FROM aq_relative_humidity
                    GROUP BY humidity_sensor
                ) AS latest ON aqrm.humidity_sensor = latest.humidity_sensor AND CONCAT(aqrm.humidity_date, ' ', aqrm.humidity_time) = latest.max_datetime
                WHERE aqs.aq_sensor_room_num IN ('$roomNumbers')
                ORDER BY aqs.aq_sensor_room_num ASC
                LIMIT $offset, $rows_per_page";
                
        $result_table = mysqli_query($con, $sql);

        while ($row = mysqli_fetch_assoc($result_table)){
            echo "<tr>";
            echo "<td>" . $row['aq_sensor_room_num'] . "</td>";
            echo "<td>" . $row['humidity_sensor'] . "</td>";
            echo "<td>" . $row['aq_sensor_name'] . "</td>";
            echo "<td>" . $row['humidity_date'] . "</td>";
            echo "<td>" . $row['humidity_time'] . "</td>";
            echo "<td>" . $row['humidity_level_data']  . "%". "</td>";
            echo "</tr>";
        }

        $total_rows_result = mysqli_query($con, "SELECT FOUND_ROWS()");
        $total_rows_row = mysqli_fetch_row($total_rows_result);
        $total_rows = $total_rows_row[0];

        $total_pages = ceil($total_rows / $rows_per_page);
    } else {}
?>