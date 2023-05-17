<?php 
    require_once('housekeep_connect.php');

    $roleIdsQuery = "SELECT building_floor, bldg_floor_name FROM building_floor";
    $roleIdsResult = mysqli_query($con, $roleIdsQuery);
    
    echo '<label for="building_floor">Building Floor:</label>';
    echo '<select id="building_floor" name="building_floor" class="building_floor" required>';
    while ($row = mysqli_fetch_assoc($roleIdsResult)) {
        echo '<option value="' . $row['building_floor'] . '">' . $row['bldg_floor_name'] . '</option>';
    }
    echo '</select>';
?>