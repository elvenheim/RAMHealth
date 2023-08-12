<?php     
require_once('ac_gauge_connect.php');

// Initialize variables
$total_energy_consumption = 0;
$tables_count = 0;

// Function to calculate Energy Intensity Index
function calculateEnergyIntensityIndex($kwh_consumption, $num_records) {
    if ($num_records == 0) {
        return 0;
    }
    return $kwh_consumption / $num_records;
}

if (isset($_POST['room_number'])) {
    $selectedSensors = $_POST['room_number'];

    $_SESSION['selected_rooms'] = $selectedSensors;

    // Combine selected sensors
    $sensors = implode("','", $selectedSensors);

    if (empty($sensors)) {
        echo "Please select rooms to show data";
    }

    // Define an array to store the Energy Intensity Index for each table
    $energy_intensity_index_table = array();
    $kwh_consumption_table = array();
    $num_records_table = array();

    // Query for ACU data
    $acu_sql = "SELECT acu.*, eas.arduino_bldg_floor, eas.arduino_room_num, bf.bldg_floor_name, st.sensor_type_name
                FROM ec_param_acu_data acu
                JOIN ec_arduino_sensors eas ON acu.ec_sensor_acu_id = eas.ec_arduino_sensors_id
                LEFT JOIN room_number rn ON eas.arduino_room_num = rn.room_num
                LEFT JOIN sensor_type st ON eas.ec_arduino_sensors_type = st.sensor_type_id
                LEFT JOIN building_floor bf ON rn.bldg_floor = bf.building_floor
                INNER JOIN (
                    SELECT ec_sensor_acu_id, MAX(CONCAT(ec_acu_date, ' ', ec_acu_time)) AS max_datetime
                    FROM ec_param_acu_data
                    GROUP BY ec_sensor_acu_id
                ) AS latest ON acu.ec_sensor_acu_id = latest.ec_sensor_acu_id 
                AND CONCAT(acu.ec_acu_date, ' ', acu.ec_acu_time) = latest.max_datetime
                WHERE eas.arduino_room_num IN ('$sensors')
                ORDER BY acu.ec_sensor_acu_id ASC";

    // Execute ACU query
    $acu_result = mysqli_query($con, $acu_sql);
    while ($row = mysqli_fetch_assoc($acu_result)) {
        $current = $row['ec_acu_current'] ?? 0;
        $time = strtotime($row['ec_acu_time']);
        $voltage = 220; // Assuming voltage is 220 V
        $watts = $voltage * $current;
        $kwh_consumption = ($watts * $time) / (1000 * 3600); // kWh = (W * t) / (1000 * 3600)
        $num_records_table['acu']++;
        $kwh_consumption_table['acu'] += $kwh_consumption;
        $total_energy_consumption += $current;
    }

    // Query for Lights data
    $lights_sql = "SELECT lght.*, eas.arduino_bldg_floor, eas.arduino_room_num, bf.bldg_floor_name, st.sensor_type_name
                    FROM ec_param_lights_data lght
                    JOIN ec_arduino_sensors eas ON lght.ec_sensor_lights_id = eas.ec_arduino_sensors_id
                    LEFT JOIN room_number rn ON eas.arduino_room_num = rn.room_num
                    LEFT JOIN sensor_type st ON eas.ec_arduino_sensors_type = st.sensor_type_id
                    LEFT JOIN building_floor bf ON rn.bldg_floor = bf.building_floor
                    INNER JOIN (
                        SELECT ec_sensor_lights_id, MAX(CONCAT(ec_lights_date, ' ', ec_lights_time)) AS max_datetime
                        FROM ec_param_lights_data
                        GROUP BY ec_sensor_lights_id
                    ) AS latest ON lght.ec_sensor_lights_id = latest.ec_sensor_lights_id 
                    AND CONCAT(lght.ec_lights_date, ' ', lght.ec_lights_time) = latest.max_datetime
                    WHERE eas.arduino_room_num IN ('$sensors')
                    ORDER BY lght.ec_sensor_lights_id ASC";

    // Execute Lights query
    $lights_result = mysqli_query($con, $lights_sql);
    while ($row = mysqli_fetch_assoc($lights_result)) {
        $current = $row['ec_lights_current'] ?? 0;
        $time = strtotime($row['ec_lights_time']);
        $voltage = 120; // Assuming voltage is 120 V
        $watts = $voltage * $current;
        $kwh_consumption = ($watts * $time) / (1000 * 3600); // kWh = (W * t) / (1000 * 3600)
        $num_records_table['lights']++;
        $kwh_consumption_table['lights'] += $kwh_consumption;
        $total_energy_consumption += $current;
    }

    // Query for Others data
    $others_sql = "SELECT oth.*, eas.arduino_bldg_floor, eas.arduino_room_num, bf.bldg_floor_name, st.sensor_type_name
                    FROM ec_param_others_data oth
                    JOIN ec_arduino_sensors eas ON oth.ec_sensor_others_id = eas.ec_arduino_sensors_id
                    LEFT JOIN room_number rn ON eas.arduino_room_num = rn.room_num
                    LEFT JOIN sensor_type st ON eas.ec_arduino_sensors_type = st.sensor_type_id
                    LEFT JOIN building_floor bf ON rn.bldg_floor = bf.building_floor
                    INNER JOIN (
                        SELECT ec_sensor_others_id, MAX(CONCAT(ec_others_date, ' ', ec_others_time)) AS max_datetime
                        FROM ec_param_others_data
                        GROUP BY ec_sensor_others_id
                    ) AS latest ON oth.ec_sensor_others_id = latest.ec_sensor_others_id 
                    AND CONCAT(oth.ec_others_date, ' ', oth.ec_others_time) = latest.max_datetime
                    WHERE eas.arduino_room_num IN ('$sensors')
                    ORDER BY oth.ec_sensor_others_id ASC";

    // Execute Others query
    $others_result = mysqli_query($con, $others_sql);
    while ($row = mysqli_fetch_assoc($others_result)) {
        $current = $row['ec_others_current'] ?? 0;
        $time = strtotime($row['ec_others_time']);
        $voltage = 220; // Assuming voltage is 220 V
        $watts = $voltage * $current;
        $kwh_consumption = ($watts * $time) / (1000 * 3600); // kWh = (W * t) / (1000 * 3600)
        $num_records_table['others']++;
        $kwh_consumption_table['others'] += $kwh_consumption;
        $total_energy_consumption += $current;
    }

    // Query for Outlet data
    $outlet_sql = "SELECT outl.*, eas.arduino_bldg_floor, eas.arduino_room_num, bf.bldg_floor_name, st.sensor_type_name
                    FROM ec_param_outlet_data outl
                    JOIN ec_arduino_sensors eas ON outl.ec_sensor_outlet_id = eas.ec_arduino_sensors_id
                    LEFT JOIN room_number rn ON eas.arduino_room_num = rn.room_num
                    LEFT JOIN sensor_type st ON eas.ec_arduino_sensors_type = st.sensor_type_id
                    LEFT JOIN building_floor bf ON rn.bldg_floor = bf.building_floor
                    INNER JOIN (
                        SELECT ec_sensor_outlet_id, MAX(CONCAT(ec_outlet_date, ' ', ec_outlet_time)) AS max_datetime
                        FROM ec_param_outlet_data
                        GROUP BY ec_sensor_outlet_id
                    ) AS latest ON outl.ec_sensor_outlet_id = latest.ec_sensor_outlet_id 
                    AND CONCAT(outl.ec_outlet_date, ' ', outl.ec_outlet_time) = latest.max_datetime
                    WHERE eas.arduino_room_num IN ('$sensors')
                    ORDER BY outl.ec_sensor_outlet_id ASC";

    // Execute Outlet query
    $outlet_result = mysqli_query($con, $outlet_sql);
    while ($row = mysqli_fetch_assoc($outlet_result)) {
        $current = $row['ec_outlet_current'] ?? 0;
        $time = strtotime($row['ec_outlet_time']);
        $voltage = 220; // Assuming voltage is 220 V
        $watts = $voltage * $current;
        $kwh_consumption = ($watts * $time) / (1000 * 3600); // kWh = (W * t) / (1000 * 3600)
        $num_records_table['outlet']++;
        $kwh_consumption_table['outlet'] += $kwh_consumption;
        $total_energy_consumption += $current;
    }

    // Query for Utilities data
    $utilities_sql = "SELECT utl.*, eas.arduino_bldg_floor, eas.arduino_room_num, bf.bldg_floor_name, st.sensor_type_name
                        FROM ec_param_util_data utl
                        JOIN ec_arduino_sensors eas ON utl.ec_sensor_util_id = eas.ec_arduino_sensors_id
                        LEFT JOIN room_number rn ON eas.arduino_room_num = rn.room_num
                        LEFT JOIN sensor_type st ON eas.ec_arduino_sensors_type = st.sensor_type_id
                        LEFT JOIN building_floor bf ON rn.bldg_floor = bf.building_floor
                        INNER JOIN (
                            SELECT ec_sensor_util_id, MAX(CONCAT(ec_util_date, ' ', ec_util_time)) AS max_datetime
                            FROM ec_param_util_data
                            GROUP BY ec_sensor_util_id
                        ) AS latest ON utl.ec_sensor_util_id = latest.ec_sensor_util_id 
                        AND CONCAT(utl.ec_util_date, ' ', utl.ec_util_time) = latest.max_datetime
                        WHERE eas.arduino_room_num IN ('$sensors')
                        ORDER BY utl.ec_sensor_util_id ASC";

    // Execute Utilities query
    $utilities_result = mysqli_query($con, $utilities_sql);
    while ($row = mysqli_fetch_assoc($utilities_result)) {
        $current = $row['ec_util_current'] ?? 0;
        $time = strtotime($row['ec_util_time']);
        $voltage = 220; // Assuming voltage is 220 V
        $watts = $voltage * $current;
        $kwh_consumption = ($watts * $time) / (1000 * 3600); // kWh = (W * t) / (1000 * 3600)
        $num_records_table['util']++;
        $kwh_consumption_table['util'] += $kwh_consumption;
        $total_energy_consumption += $current;
    }

    // Calculate the total kWh consumption
    $total_kwh_consumption = array_sum($kwh_consumption_table);

    // Output Energy Intensity Index and Total Energy Consumption
$tables_count = count($num_records_table);
if ($tables_count > 0) {
    $average_kwh_consumption = $total_kwh_consumption / $tables_count;

    // Check if the energy intensity index exists for each table and output the value
    if (isset($num_records_table['acu'])) {
        $energy_intensity_index = calculateEnergyIntensityIndex($kwh_consumption_table['acu'], $num_records_table['acu']);
        echo "ACU Energy Intensity Index: " . $energy_intensity_index . "<br>";
    }
    if (isset($num_records_table['lights'])) {
        $energy_intensity_index = calculateEnergyIntensityIndex($kwh_consumption_table['lights'], $num_records_table['lights']);
        echo "Lights Energy Intensity Index: " . $energy_intensity_index . "<br>";
    }
    if (isset($num_records_table['others'])) {
        $energy_intensity_index = calculateEnergyIntensityIndex($kwh_consumption_table['others'], $num_records_table['others']);
        echo "Others Energy Intensity Index: " . $energy_intensity_index . "<br>";
    }
    if (isset($num_records_table['outlet'])) {
        $energy_intensity_index = calculateEnergyIntensityIndex($kwh_consumption_table['outlet'], $num_records_table['outlet']);
        echo "Outlet Energy Intensity Index: " . $energy_intensity_index . "<br>";
    }
    if (isset($num_records_table['util'])) {
        $energy_intensity_index = calculateEnergyIntensityIndex($kwh_consumption_table['util'], $num_records_table['util']);
        echo "Utilities Energy Intensity Index: " . $energy_intensity_index . "<br>";
    }

    echo "Average Energy Intensity Index: " . $average_energy_intensity_index . "<br>";
} else {
    echo "Average Energy Intensity Index: 0<br>";
}
echo "Total Energy Consumption: " . $total_energy_consumption . " amps<br>";

    // Reset result pointers
    mysqli_data_seek($acu_result, 0);
    mysqli_data_seek($lights_result, 0);
    mysqli_data_seek($others_result, 0);
    mysqli_data_seek($outlet_result, 0);
    mysqli_data_seek($utilities_result, 0);
}
?>
