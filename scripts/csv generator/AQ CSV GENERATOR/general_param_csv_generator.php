<?php 
    // Generate randomized data for outdoor_temp table
    $csvData = "air_quality_room_num,aq_gas_id,aq_indoor_temp_id,aq_outdoor-temp_id, aq_pm_id, aq_humidity_id" . PHP_EOL; //you may change your table headers

    $startDate = strtotime('2023-01-01');
    $endDate = strtotime('2023-06-13');

    $counter = 1;

    $startSensor = 801;
    $endSensor = 811;
    
    for ($i = 1; $i <= 100; $i++) {
        $sensorNumber = ($i % ($endSensor - $startSensor + 1)) + $startSensor;
        $roomNumber = ($i % ($endSensor - $startSensor + 1)) + $startSensor;
        $sensor_gas = "AQ" . sprintf('%03d', $sensorNumber) . "GAS01"; //sensor name generator
        $sensor_indoor_temp = "AQ" . sprintf('%03d', $sensorNumber) . "INTEMP01"; //sensor name generator
        $sensor_outdoor_temp = "AQ" . sprintf('%03d', $sensorNumber) . "OUTTEMP01"; //sensor name generator
        $sensor_pm = "AQ" . sprintf('%03d', $sensorNumber) . "PM01"; //sensor name generator
        $sensor_humidity = "AQ" . sprintf('%03d', $sensorNumber) . "RELHUM01"; //sensor name generator
    
        $csvData .= "$roomNumber,$sensor_gas,$sensor_indoor_temp,$sensor_outdoor_temp,$sensor_pm,$sensor_humidity" . PHP_EOL; //row data generator
    }
    

    // Save the randomized data to a CSV file
    $fileName = "air_quality_table_import.csv";
    $file = fopen($fileName, 'w');
    fwrite($file, $csvData);
    fclose($file);

    // Provide download link to the generated CSV file
    echo "Randomized data has been exported to <a href='$fileName' download>CSV file</a>.";

?>