<?php 
    require_once('air_technician_connect.php');

    $roomQuery = "SELECT room_num FROM room_number";
    $roomResult = mysqli_query($con, $roomQuery);
    
    echo '<label for="room_number">Room Number:</label>';
    echo '<select id="room_number" name="room_number" class="room_number" required>';
    echo '<option value="" disabled selected>-Select Room-</option>';
    while ($row = mysqli_fetch_assoc($roomResult)) {
        echo '<option value="' . $row['room_num'] . '">' . $row['room_num'] . '</option>';
    }
    echo '</select><br>';
?>
