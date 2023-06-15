<?php     
    require_once('ac_gauge_connect.php');

    if (isset($_POST['room_number'])) {
        // Retrieve the selected room numbers
        $selectedRoom = $_POST['room_number'];

        $_SESSION['selected_room'] = $selectedRoom;

        $sql = "SELECT SQL_CALC_FOUND_ROWS aqit.*, aqs.aq_sensor_room_num, aqs.aq_sensor_name
                FROM aq_indoor_temperature aqit
                JOIN aq_sensor aqs ON aqit.indoor_temp_sensor = aqs.aq_sensor_id
                INNER JOIN (
                    SELECT indoor_temp_sensor, MAX(CONCAT(indoor_temp_date, ' ', indoor_temp_time)) AS max_datetime
                    FROM aq_indoor_temperature
                    GROUP BY indoor_temp_sensor
                ) AS latest ON aqit.indoor_temp_sensor = latest.indoor_temp_sensor 
                AND CONCAT(aqit.indoor_temp_date, ' ', aqit.indoor_temp_time) = latest.max_datetime
                WHERE aqs.aq_sensor_room_num IN ('$selectedRoom')";
                
        $result_table = mysqli_query($con, $sql);

        $indoor_temperature = [];

        while ($row = mysqli_fetch_assoc($result_table)){
            $indoor_temperature[] = $row['indoor_temp_data'];
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
    <span class="gauge-title">Indoor Temperature (Latest)</span>
    <div id="indoor-temperature-gauge" class="gauge"></div>
    <script>
        $(document).ready(function() {
            // Configuration options for the gauge
            var gaugeConfig = {
                id: 'indoor-temperature-gauge',
                value: '<?php echo isset($indoor_temperature[0]) ? $indoor_temperature[0] : 0 ; ?>',
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

