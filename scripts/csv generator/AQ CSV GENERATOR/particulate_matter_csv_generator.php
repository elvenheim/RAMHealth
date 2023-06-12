<?php 
    // Generate randomized data for indoor_temp table
    $csvData = "pm_sensor,pm_ten,pm_two_five,pm_zero_one,pm_date,pm_time" . PHP_EOL; //you may change your table headers

    $startDate = strtotime('2023-01-01');
    $endDate = strtotime('2023-06-13');

    $counter = 1;

    $startSensor = 801;
    $endSensor = 811;
    
    for ($i = 0; $i <= 1000; $i++) {
        $sensorNumber = ($i % ($endSensor - $startSensor + 1)) + $startSensor;
        $sensor = "AQ" . sprintf('%03d', $sensorNumber) . "PM01"; //sensor name generator
        $data = mt_rand(5, 43); //data input randomizer, case for me is that 26 to 40 are the values
        $data2 = mt_rand(5, 65); //data input randomizer, case for me is that 26 to 40 are the values
        $data3 = mt_rand(5, 53); //data input randomizer, case for me is that 26 to 40 are the values
        $date = date('Y-m-d', mt_rand($startDate, $endDate)); //date randomizer
        $time = date('H:i:s', mt_rand(strtotime('07:00:00'), strtotime('19:00:00'))); //time randomizer
    
        $csvData .= "$sensor,$data,$data2,$data3,$date,$time" . PHP_EOL; //row data generator
    }
    

    // Save the randomized data to a CSV file
    $fileName = "pm_data.csv";
    $file = fopen($fileName, 'w');
    fwrite($file, $csvData);
    fclose($file);

    // Provide download link to the generated CSV file
    echo "Randomized data has been exported to <a href='$fileName' download>CSV file</a>.";

?>