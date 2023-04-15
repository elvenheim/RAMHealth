<?php 
    require('admin_connect.php');
    // Fetch data from the database
    $sql = "SELECT u.*, r.role_name 
            FROM user u
            JOIN role_type r 
            ON u.user_role = r.role_id";
    $result_table = mysqli_query($con, $sql);
    
    // Loop through the data and create table rows
    while ($row = mysqli_fetch_assoc($result_table)){
        echo "<tr>";
        echo "<td>" . $row['user_id'] . "</td>";
        echo "<td>" . $row['role_name'] . "</td>";
        echo "<td>" . $row['user_fullname'] . "</td>";
        echo "<td>" . $row['user_email'] . "</td>";
        echo "<td>" . $row['user_create_at'] . "</td>";
        echo "<td>";
        switch ($row['user_status']){
            case 1:     
                echo "Active";
                break;
            default:
                echo "Deactive";
                break;
        }
        echo "</td>";
        echo "</tr>";
    }
    mysqli_close($con);
?>
