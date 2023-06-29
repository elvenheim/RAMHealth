<?php 
    require_once('building_head_connect.php');

    $roomQuery = "SELECT rn.*, bf.building_floor, bf.bldg_floor_name
                FROM room_number rn
                JOIN building_floor bf ON rn.bldg_floor = bf.building_floor
                GROUP BY bf.building_floor
                ORDER BY bf.building_floor ASC";
    $roomResult = mysqli_query($con, $roomQuery);

    echo '<form id="floor-selection-form">';
    echo '<label for="bldg_floor">Floor: </label>';
    echo '<select id="bldg_floor" name="bldg_floor" class="bldg_floor" required onchange="updateRoomsDropdown(this.value)">';
    echo '<option value="" disabled selected>-Select Floor-</option>';
    while ($row = mysqli_fetch_assoc($roomResult)) {
        echo '        <option value="' . $row['building_floor'] . '">' . $row['bldg_floor_name'] . '</option>';
    }
    echo '</select><br>';
    echo '</form>';

    $_SESSION['selected_floor'] = isset($_POST['building_floor']) ? $_POST['building_floor'] : '';
?>
