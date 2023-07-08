<?php
    require_once('ac_gauge_connect.php');

    if (isset($_POST['room_number'])) {
        // Retrieve the selected room numbers
        $selectedRooms = $_POST['room_number'];

        $_SESSION['selected_rooms'] = $selectedRooms;

        $gasLevels = array();

        foreach ($selectedRooms as $room) {
            $sql = "SELECT SQL_CALC_FOUND_ROWS aqg.*, aqs.aq_sensor_room_num, aqs.aq_sensor_name
                    FROM aq_gas_level aqg
                    JOIN aq_sensor aqs ON aqg.gas_sensor = aqs.aq_sensor_id
                    INNER JOIN (
                        SELECT gas_sensor, MAX(CONCAT(gas_date, ' ', gas_time)) AS max_datetime
                        FROM aq_gas_level
                        GROUP BY gas_sensor
                    ) AS latest ON aqg.gas_sensor = latest.gas_sensor 
                    AND CONCAT(aqg.gas_date, ' ', aqg.gas_time) = latest.max_datetime
                    WHERE aqs.aq_sensor_room_num = '$room'";

            $result_table = mysqli_query($con, $sql);

            while ($row = mysqli_fetch_assoc($result_table)) {
                $gasLevels[$room] = $row['gas_level_data'];
            }
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Gauge Example</title>
    <link rel="stylesheet" href="../Building Management Head/gauges/energy_gauge.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.3.0/raphael.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/justgage/1.6.1/justgage.min.js"></script>
</head>
<body>
    <div class="gauge-card">
        <?php
            if (!empty($selectedRooms)) {
                foreach ($selectedRooms as $room) {
                    echo '<div class="gauge-container">';
                    echo '<span class="room-label">Room ' . $room . '</span>';
                    echo '<div id="energy-gauge-' . $room . '" class="gauge"></div>';
                    echo '</div>';
                }
            } else {
                echo '<div class="no-rooms">No rooms selected.</div>';
            }
        ?>
    </div>
    <script>
        $(document).ready(function() {
        <?php
            if (!empty($selectedRooms)) {
            foreach ($selectedRooms as $room) {
                echo 'createGauge("energy-gauge-' . $room . '", ' . ($gasLevels[$room] ?? 0) . ');';
            }
            }
        ?>

        function createGauge(gaugeId, gasLevel) {
            var gaugeConfig = {
            id: gaugeId,
            value: gasLevel,
            symbol: ' amps',
            valueFontColor: '#000000',
            valueMinFontSize: 5,
            min: 0,
            max: 4000,
            minLabelMinFontSize: 10,
            maxLabelMinFontSize: 10,
            label: '    ',
            labelFontColor: '#000000',
            labelMinFontSize: 15,
            gaugeWidthScale: 0.9,
            counter: true,
            levelColors: ['#E7AE41'],
            width: 100,
            pointer: true,
            pointerOptions: {
                toplength: -15,
                bottomlength: 10,
                bottomwidth: 5,
                color: 'lightblue',
                stroke: '#ffffff',
                stroke_width: 0
            },
            };

            new JustGage(gaugeConfig);
        }
        });
    </script>
</body>
</html>