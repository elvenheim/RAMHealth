<?php     
    require_once('building_head_connect.php');

    if (isset($_POST['room_number'])) {
        // Retrieve the selected room numbers
        $selectedRoom = $_POST['room_number'];

        $_SESSION['selected_room'] = $selectedRoom;

        $sql = "SELECT SQL_CALC_FOUND_ROWS aqrm.*, aqs.aq_sensor_room_num, aqs.aq_sensor_name
                FROM aq_relative_humidity aqrm
                JOIN aq_sensor aqs ON aqrm.humidity_sensor = aqs.aq_sensor_id
                INNER JOIN (
                    SELECT humidity_sensor, MAX(CONCAT(humidity_date, ' ', humidity_time)) AS max_datetime
                    FROM aq_relative_humidity
                    GROUP BY humidity_sensor
                ) AS latest ON aqrm.humidity_sensor = latest.humidity_sensor 
                AND CONCAT(aqrm.humidity_date, ' ', aqrm.humidity_time) = latest.max_datetime
                WHERE aqs.aq_sensor_room_num IN ('$selectedRoom')";
                
        $result_table = mysqli_query($con, $sql);

        $humidityLevels = [];

        while ($row = mysqli_fetch_assoc($result_table)){
            $humidityLevels[] = $row['humidity_level_data'];
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Gauge Example</title>
    <link rel="stylesheet" href="../Building Management Head/gauges/gauges.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.3.0/raphael.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/justgage/1.6.1/justgage.min.js"></script>
</head>
<body>
    <span class="gauge-title">Relative Humidity (Latest)</span>
    <div id="humidity-gauge" class="gauge"></div>
    <script>
        $(document).ready(function() {
            // Configuration options for the gauge
            var gaugeConfig = {
                id: 'humidity-gauge',
                value: '<?php echo isset($humidityLevels[0]) ? $humidityLevels[0] : 0 ; ?>',
                symbol: '%',      
                valueFontColor: '#000000',
                min: 0,
                max: 100,
                minLabelMinFontSize: 10,
                maxLabelMinFontSize: 10,
                label: '',
                labelFontColor: '#000000',
                labelMinFontSize: 12,
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

            // Create the gauge element
            var gauge = new JustGage(gaugeConfig);
        });
    </script>
</body>
</html>

