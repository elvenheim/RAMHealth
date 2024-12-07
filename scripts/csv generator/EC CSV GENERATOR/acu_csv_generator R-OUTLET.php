<?php
    // Generate randomized data for indoor_temp table
    $csvData = "ec_sensor_outlet_id,ec_outlet_date,ec_outlet_time,ec_outlet_current" . PHP_EOL; //you may change your table headers

    $startDate = strtotime('2023-06-01');
    $endDate = strtotime('2023-07-31');

    $counter = 1;

    $startSensor = 1;
    $endSensor = 3;

    for ($i = 1; $i <= 200; $i++) {
        $sensorNumber = mt_rand($startSensor, $endSensor);
        $sensor = "R-OUTLET1-$sensorNumber"; // sensor name generator
        $data = mt_rand(0, 120); // data input randomizer, case for me is that 26 to 40 are the values
        $date = date('Y-m-d', mt_rand($startDate, $endDate)); // date randomizer
        $time = date('H:i:s', mt_rand(strtotime('07:00:00'), strtotime('19:00:00'))); // time randomizer

        $csvData .= "$sensor,$date,$time,$data" . PHP_EOL; // row data generator
    }

    // Save the randomized data to a CSV file
    $fileName = "outlet_data_outlet2.csv";
    $file = fopen($fileName, 'w');
    fwrite($file, $csvData);
    fclose($file);

    // Provide download link to the generated CSV file
    echo "Randomized data has been exported to <a href='$fileName' download>CSV file</a>.";
?>