<?php
    require('housekeep_connect.php');
    // Fetch data from the database
    $sql = "SELECT * FROM room_number";
    $result_table = mysqli_query($con, $sql);
        
    // Loop through the data and create table rows
    while ($row = mysqli_fetch_assoc($result_table)){
        echo "<tr>";
        echo "<td>";
        switch ($row['bldg_floor']) {
            case 12:
                echo "12th";
                break;
            case 11:
                echo "11th";
                break;
            case 10:
                echo "10th";
                break;
            case 9:
                echo "9th";
                break;
            case 8:
                echo "8th";
                break;
            case 7:
                echo "7th";
                break;
            case 6:
                echo "6th";
                break;
            case 5:
                echo "5th";
                break;
            case 4:
                echo "4th";
                break;
            case 3:
                echo "3rd";
                break;
            case 2:
                echo "2nd";
                break;
            default:
                echo "1st";
                break;
        }
        echo "</td>";        
        echo "<td>" . $row['room_num'] . "</td>";
        echo "<td>" . $row['room_name'] . "</td>";
        echo "<td>" . ($row['room_type'] == 3 ? "Laboratory" : 
          ($row['room_type'] == 2 ? "Classroom" : "Faculty")) . "</td>";
        echo "<td>" . $row['room_added_at'] . "</td>";
        echo "</tr>";
    }
    mysqli_close($con);
?>