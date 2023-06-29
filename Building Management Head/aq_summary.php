<?php
    if (isset($_POST['room_number'])) {
        // Retrieve the selected room numbers
        $selectedRoom = $_POST['room_number'];
    
        $_SESSION['selected_room'] = $selectedRoom;
    
        $sql = "SELECT aqt.*, rn.bldg_floor, it.indoor_temp_data, ot.outdoor_temp_data, pm.pm_ten, 
                pm.pm_two_five, pm.pm_zero_one, rh.humidity_level_data, gs.gas_level_data
                FROM air_quality_table aqt
                LEFT JOIN aq_sensor aqs ON aqt.air_quality_room_num = aqs.aq_sensor_room_num
                LEFT JOIN room_number rn ON aqs.aq_sensor_room_num = rn.room_num
                LEFT JOIN (
                    SELECT pm_sensor, MAX(CONCAT(pm_date, ' ', pm_time)) AS max_datetime
                    FROM aq_particulate_matter
                    GROUP BY pm_sensor
                ) AS latest_pm ON aqt.aq_pm_id = latest_pm.pm_sensor
                LEFT JOIN aq_particulate_matter pm ON aqt.aq_pm_id = pm.pm_sensor AND CONCAT(pm.pm_date, ' ', pm.pm_time) = latest_pm.max_datetime
                LEFT JOIN (
                    SELECT gas_sensor, MAX(CONCAT(gas_date, ' ', gas_time)) AS max_datetime
                    FROM aq_gas_level
                    GROUP BY gas_sensor
                ) AS latest_gas ON aqt.aq_gas_id = latest_gas.gas_sensor
                LEFT JOIN aq_gas_level gs ON aqt.aq_gas_id = gs.gas_sensor AND CONCAT(gs.gas_date, ' ', gs.gas_time) = latest_gas.max_datetime
                LEFT JOIN (
                    SELECT indoor_temp_sensor, MAX(CONCAT(indoor_temp_date, ' ', indoor_temp_time)) AS max_datetime
                    FROM aq_indoor_temperature
                    GROUP BY indoor_temp_sensor
                ) AS latest_indoor_temp ON aqt.aq_indoor_temp_id = latest_indoor_temp.indoor_temp_sensor
                LEFT JOIN aq_indoor_temperature it ON aqt.aq_indoor_temp_id = it.indoor_temp_sensor AND CONCAT(it.indoor_temp_date, ' ', it.indoor_temp_time) = latest_indoor_temp.max_datetime
                LEFT JOIN (
                    SELECT outdoor_temp_sensor, MAX(CONCAT(outdoor_temp_date, ' ', outdoor_temp_time)) AS max_datetime
                    FROM aq_outdoor_temperature
                    GROUP BY outdoor_temp_sensor
                ) AS latest_outdoor_temp ON aqt.aq_outdoor_temp_id = latest_outdoor_temp.outdoor_temp_sensor
                LEFT JOIN aq_outdoor_temperature ot ON aqt.aq_outdoor_temp_id = ot.outdoor_temp_sensor AND CONCAT(ot.outdoor_temp_date, ' ', ot.outdoor_temp_time) = latest_outdoor_temp.max_datetime
                LEFT JOIN (
                    SELECT humidity_sensor, MAX(CONCAT(humidity_date, ' ', humidity_time)) AS max_datetime
                    FROM aq_relative_humidity
                    GROUP BY humidity_sensor
                ) AS latest_humidity ON aqt.aq_humidity_id = latest_humidity.humidity_sensor
                LEFT JOIN aq_relative_humidity rh ON aqt.aq_humidity_id = rh.humidity_sensor AND CONCAT(rh.humidity_date, ' ', rh.humidity_time) = latest_humidity.max_datetime
                WHERE air_quality_room_num IN ('$selectedRoom')
                GROUP BY air_quality_table_id
                ORDER BY air_quality_room_num";
    
        $result_table = mysqli_query($con, $sql);
    
        if (mysqli_num_rows($result_table) > 0) {
            while ($row = mysqli_fetch_assoc($result_table)) {
                echo "<span class='summary-title'>Latest Summary in ". $selectedRoom . "</span><br>";
                echo "PM10: " . ($row['pm_ten'] !== null && $row['pm_ten'] !== '' ? $row['pm_ten'] . " µg/m³" : "N/A") . "<br>";
                echo "PM2.5: " . ($row['pm_two_five'] !== null && $row['pm_two_five'] !== '' ? $row['pm_two_five'] . " µg/m³" : "N/A") . "<br>";
                echo "PM0.1: " . ($row['pm_zero_one'] !== null && $row['pm_zero_one'] !== '' ? $row['pm_zero_one'] . " µg/m³" : "N/A") . "<br>";
                echo "Gas Level: " . ($row['gas_level_data'] !== null && $row['gas_level_data'] !== '' ? $row['gas_level_data'] . " ppm" : "N/A") . "<br>";
                echo "Indoor Temperature: " . ($row['indoor_temp_data'] !== null && $row['indoor_temp_data'] !== '' ? $row['indoor_temp_data'] . "°C" : "N/A") . "<br>";
                echo "Outdoor Temperature: " . ($row['outdoor_temp_data'] !== null && $row['outdoor_temp_data'] !== '' ? $row['outdoor_temp_data'] . "°C" : "N/A") . "<br>";
                echo "Humidity Level: " . ($row['humidity_level_data'] !== null && $row['humidity_level_data'] !== '' ? $row['humidity_level_data'] . "%" : "N/A") . "<br>";
                echo "<br>";
            }
        } else {
            echo "<span class='summary-title'>Latest Summary in ". $selectedRoom . "</span><br>";
            echo "No data found...";
            echo "<br> <br> <br>";
            echo "<br> <br> <br>";
            echo "<br> <br>";
        }
    } else {
        echo "<span class='summary-title'>Latest Summary</span><br>";
        echo "Select a Room";
        echo "<br> <br> <br>";
        echo "<br> <br> <br>";
        echo "<br> <br>";
    }    
?>
