<?php
    require('housekeep_connect.php');
    // Fetch data from the database
    $sql = "SELECT * FROM room_number";
    $result_table = mysqli_query($con, $sql);
        
    // Loop through the data and create table rows
    while ($row = mysqli_fetch_assoc($result_table)){
        echo "<tr>";
        echo "<td>";
        $floor_names = array(
            "1" => "1st", "2" => "2nd", "3" => "3rd", "4" => "4th", "5" => "5th",
            "6" => "6th", "7" => "7th", "8" => "8th", "9" => "9th","10" => "10th",
            "11" => "11th", "12" => "12th"
        );
        echo $floor_names[$row['bldg_floor']];
        echo "</td>";        
        echo "<td>" . $row['room_num'] . "</td>";
        echo "<td>" . $row['room_name'] . "</td>";
        echo "<td>";
        switch ($row['room_type']){
            case 3:
                echo "Laboratory";
                break;
            case 2:
                echo "Classroom";
                break;
            case 1:
                echo "Faculty";
                break;
            default:
                echo " ";
                break;
        }
        echo "</td>";
        echo "<td>" . $row['room_added_at'] . "</td>";
        echo "</tr>";
    }
    mysqli_close($con);
?>