<?php 
    require_once('air_technician_connect.php');

    $roleIdsQuery = "SELECT room_num FROM room_number";
    $roleIdsResult = mysqli_query($con, $roleIdsQuery);
    
    echo '<label for="room_number">Room Number:</label>';
    echo '<select id="room_number" name="room_number" class="room_number" required>';
    echo '<option value="" disabled selected>-Select Room-</option>';
    while ($row = mysqli_fetch_assoc($roleIdsResult)) {
        echo '<option value="' . $row['room_num'] . '">' . $row['room_num'] . '</option>';
    }
    echo '</select><br>';
?>
