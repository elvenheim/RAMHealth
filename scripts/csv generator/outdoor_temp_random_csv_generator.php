<?php 
    // Generate randomized data for outdoor_temp table
    $csvData = "outdoor_temp_id,outdoor_temp_sensor,outdoor_temp_data,outdoor_temp_date,outdoor_temp_time" . PHP_EOL; //you may change your table headers

    $startDate = strtotime('2023-05-01');
    $endDate = strtotime('2023-05-31');

    $counter = 1;

    $startSensor = 801;
    $endSensor = 811;
    
    for ($i = 1; $i <= 200; $i++) {
        $sensorNumber = ($i % ($endSensor - $startSensor + 1)) + $startSensor;
        $sensor = "AQ" . sprintf('%03d', $sensorNumber) . "OUTTEMP01"; //sensor name generator
        $data = mt_rand(26, 40); //data input randomizer, case for me is that 26 to 40 are the values
        $date = date('Y-m-d', mt_rand($startDate, $endDate)); //date randomizer
        $time = date('H:i:s', mt_rand(strtotime('07:00:00'), strtotime('19:00:00'))); //time randomizer
    
        $csvData .= "$i,$sensor,$data,$date,$time" . PHP_EOL; //row data generator
    }
    

    // Save the randomized data to a CSV file
    $fileName = "outdoor_temp_data.csv";
    $file = fopen($fileName, 'w');
    fwrite($file, $csvData);
    fclose($file);

    // Provide download link to the generated CSV file
    echo "Randomized data has been exported to <a href='$fileName' download>CSV file</a>.";

?>