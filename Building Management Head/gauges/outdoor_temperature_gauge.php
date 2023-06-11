<?php     
    require_once('building_head_connect.php');

    if (isset($_POST['room_number'])) {
        // Retrieve the selected room numbers
        $selectedRoom = $_POST['room_number'];

        $_SESSION['selected_room'] = $selectedRoom;

        $sql = "SELECT SQL_CALC_FOUND_ROWS aqot.*, aqs.aq_sensor_room_num, aqs.aq_sensor_name
                FROM aq_outdoor_temperature aqot
                JOIN aq_sensor aqs ON aqOt.outdoor_temp_sensor = aqs.aq_sensor_id
                INNER JOIN (
                    SELECT outdoor_temp_sensor, MAX(CONCAT(outdoor_temp_data, ' ', outdoor_temp_time)) AS max_datetime
                    FROM aq_outdoor_temperature
                    GROUP BY outdoor_temp_sensor
                ) AS latest ON aqot.outdoor_temp_sensor = latest.outdoor_temp_sensor 
                AND CONCAT(aqot.outdoor_temp_data, ' ', aqot.outdoor_temp_time) = latest.max_datetime
                WHERE aqs.aq_sensor_room_num IN ('$selectedRoom')";
                
        $result_table = mysqli_query($con, $sql);

        $outdoor_temperature = [];

        while ($row = mysqli_fetch_assoc($result_table)){
            $outdoor_temperature[] = $row['outdoor_temp_data'];
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
    <span class="gauge-title">Outdoor Temperature (Latest)</span>
    <div id="outdoor-temperature-gauge" class="gauge"></div>
    <script>
        $(document).ready(function() {
            // Configuration options for the gauge
            var gaugeConfig = {
                id: 'outdoor-temperature-gauge',
                value: '<?php echo isset($outdoor_temperature[0]) ? $outdoor_temperature[0] : 0 ; ?>',
                symbol: '°C',      
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
                    bottomlength: 50,
                    bottomwidth: 5,
                    color: 'lightblue',
                    stroke: '#ffffff',
                    stroke_width: 1
                },
            };

            // Create the gauge element
            var gauge = new JustGage(gaugeConfig);
        });
    </script>
</body>
</html>

