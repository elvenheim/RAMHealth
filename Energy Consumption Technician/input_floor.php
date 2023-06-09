<?php 
    require_once('energy_technician_connect.php');

    $floorQuery = "SELECT rn.*, bf.building_floor, bf.bldg_floor_name
                FROM room_number rn
                JOIN building_floor bf ON rn.bldg_floor = bf.building_floor
                GROUP BY bf.building_floor
                ORDER BY bf.building_floor ASC";
    $floorResult = mysqli_query($con, $floorQuery);

    echo '<label for="bldg_floor">Building Floor:</label>';
    echo '<select id="bldg_floor" name="bldg_floor" class="bldg_floor" required>';
    echo '<option value="" disabled selected>-Select Floor-</option>';
    while ($row = mysqli_fetch_assoc($floorResult)) {
        echo '<option value="' . $row['building_floor'] . '">' . $row['bldg_floor_name'] . '</option>';
    }
    echo '</select><br>';
?>
