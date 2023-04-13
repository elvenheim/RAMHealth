<?php
    require('housekeep_connect.php');
    // Fetch data from the database
    $sql = "SELECT * FROM room_number";
    $result_table = mysqli_query($con, $sql);
        
    // Loop through the data and create table rows
    while ($row = mysqli_fetch_assoc($result_table)){
        echo "<tr>";
        echo "<td>" . $row['bldg_floor'] . "</td>";
        echo "<td>" . $row['room_num'] . "</td>";
        echo "<td>" . $row['room_name'] . "</td>";
        echo "<td>" . ($row['room_type'] == 3 ? "Laboratory" : 
          ($row['room_type'] == 2 ? "Classroom" : "Faculty")) . "</td>";
        echo "<td>" . $row['room_added_at'] . "</td>";
        echo "</tr>";
    }
    mysqli_close($con);
?>