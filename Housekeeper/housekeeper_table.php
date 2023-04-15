<?php
    require('housekeep_connect.php');
    // Fetch data from the database
    $sql = "SELECT * FROM room_number";
    $result_table = mysqli_query($con, $sql);
        
    // Loop through the data and create table rows
    while ($row = mysqli_fetch_assoc($result_table)){
        echo "<tr>";

        // Building Floor
        echo "<td>";
        
        $floor_names = array();
        // Initialize the floor names array with 1st, 2nd, and 3rd floors
        $floor_names = [1 => '1st',2 => '2nd', 3 => '3rd'];

        // Loop through floors 4-12 and add them to the array
        for ($i = 4; $i <= 12; $i++) {
            $floor_names[$i] = $i . 'th';
        }

        // Add new floors dynamically by checking if they exist in the array
        if (!isset($floor_names[$row['bldg_floor']])) {
            $floor_names[$row['bldg_floor']] = $row['bldg_floor'] . 'th';
        }

        // Output the floor name for the current row
        echo $floor_names[$row['bldg_floor']];
        echo "</td>";     
        
        //Other table contents
        echo "<td>" . $row['room_num'] . "</td>";
        echo "<td>" . $row['room_name'] . "</td>";
        echo "<td>" . $row['room_type'] . "</td>";
        echo "</td>";
        echo "<td>" . $row['room_added_at'] . "</td>";
        echo "</tr>";
    }
    mysqli_close($con);
?>