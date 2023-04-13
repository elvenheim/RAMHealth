<?php 
    require('admin_connect.php');
    // Fetch data from the database
    $sql = "SELECT * FROM user";
    $result_table = mysqli_query($con, $sql);
    
    // Loop through the data and create table rows
    while ($row = mysqli_fetch_assoc($result_table)){
        echo "<tr>";
        echo "<td>" . $row['user_id'] . "</td>";
        echo "<td>";
        switch ($row['user_role']) {
            case 5:
                echo "Building Management Head";
                break;
            case 4:
                echo "Energy Consumption Technician";
                break;
            case 3:
                echo "Air Quality Technician";
                break;
            case 2:
                echo "Housekeeper";
                break;
            default:
                echo "Administrator";
                break;
        }
        echo "</td>";
        echo "<td>" . $row['user_fullname'] . "</td>";
        echo "<td>" . $row['user_email'] . "</td>";
        echo "<td>" . $row['user_create_at'] . "</td>";
        echo "<td>" . ($row['user_status'] == 1 ? "Active" : "Deactive") . "</td>";
        echo "</tr>";
    }
    mysqli_close($con);
?>