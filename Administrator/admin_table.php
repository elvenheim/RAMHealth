<?php 
    require('admin_connect.php');
    // Fetch data from the database
    $sql = "SELECT * FROM user";
    $result_table = mysqli_query($con, $sql);
    
    // Loop through the data and create table rows
    while ($row = mysqli_fetch_assoc($result_table)){
        echo "<tr>";
        echo "<td>" . $row['user_id'] . "</td>";
        echo "<td>" . $row['user_role'] . "</td>";
        echo "<td>" . $row['user_fullname'] . "</td>";
        echo "<td>" . $row['user_email'] . "</td>";
        echo "<td>" . $row['user_create_at'] . "</td>";
        echo "<td>" . ($row['user_status'] == 1 ? "Active" : "Deactive") . "</td>";
        echo "</tr>";
    }
    mysqli_close($con);
?>