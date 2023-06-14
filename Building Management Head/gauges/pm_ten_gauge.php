<?php     
    require_once('building_head_connect.php');

    if (isset($_POST['room_number'])) {
        // Retrieve the selected room numbers
        $selectedRoom = $_POST['room_number'];

        $_SESSION['selected_room'] = $selectedRoom;

        $sql = "SELECT SQL_CALC_FOUND_ROWS aqpm.*, aqs.aq_sensor_room_num, aqs.aq_sensor_name
            FROM aq_particulate_matter aqpm
            JOIN aq_sensor aqs ON aqpm.pm_sensor = aqs.aq_sensor_id
            INNER JOIN (
                SELECT pm_sensor, MAX(CONCAT(pm_date, ' ', pm_time)) AS max_datetime
                FROM aq_particulate_matter
                GROUP BY pm_sensor
            ) AS latest ON aqpm.pm_sensor = latest.pm_sensor 
            AND CONCAT(aqpm.pm_date, ' ', aqpm.pm_time) = latest.max_datetime
            WHERE aqs.aq_sensor_room_num IN ('$selectedRoom')";
                
        $result_table = mysqli_query($con, $sql);

        $pm_ten_level = [];

        while ($row = mysqli_fetch_assoc($result_table)){
            $pm_ten_level[] = $row['pm_ten'];
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
    <span class="gauge-title">Particulate Matter 10 (Latest)</span>
    <div id="pm-ten-gauge" class="gauge"></div>
    <script>
        $(document).ready(function() {
            // Configuration options for the gauge
            var gaugeConfig = {
                id: 'pm-ten-gauge',
                value: '<?php echo isset($pm_ten_level[0]) ? $pm_ten_level[0] : 0 ; ?>',
                symbol: ' µg/m³',      
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

