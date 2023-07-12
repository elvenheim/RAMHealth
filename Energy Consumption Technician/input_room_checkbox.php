<?php 
    require_once('energy_technician_connect.php');

    if (session_status() === PHP_SESSION_NONE) {
        session_start(); // Start the session if it's not already started
    }

    if (isset($_POST['selected_floor'])) {
        $selectedFloor = $_POST['selected_floor'];
        
        $roomQuery = "SELECT room_num FROM room_number WHERE bldg_floor = ?";
        $stmt = mysqli_prepare($con, $roomQuery);
        mysqli_stmt_bind_param($stmt, 's', $selectedFloor);
        mysqli_stmt_execute($stmt);
        $roomResult = mysqli_stmt_get_result($stmt);
        
        echo '<label for="room_number">Room:</label>';
        echo '<div class="checkbox-dropdown">';
        echo '<button class="button-select-room" type="button" id="room-number-dropdown" onclick="toggleDropdown()">';
        echo '-Select Room-' ;
        echo '</button>';
        echo '<div class="dropdown-menu" id="room-number-menu">';
        echo '<div class="dropdown-item">';
        echo '<input type="checkbox" id="select-all" class="select-all" onclick="selectAll(this)" value="select-all">';
        echo '<label for="select-all">Select All</label>';
        echo '</div>';
        
        while ($row = mysqli_fetch_assoc($roomResult)) {
            $isChecked = isset($_POST['room_number']) && in_array($row['room_num'], $_POST['room_number']) ? 'checked' : '';
            echo '<div class="dropdown-item">';
            echo '<input type="checkbox" id="' . $row['room_num'] . '" name="room_number[]" value="' . $row['room_num'] . '" ' . $isChecked . '>';
            echo '<label for="' . $row['room_num'] . '">' . $row['room_num'] . '</label>';
            echo '</div>';
        }

        // Store the selected room numbers in the session
        $_SESSION['selected_rooms'] = isset($_POST['room_number']) ? $_POST['room_number'] : [];

        echo '<button button id="submit-room-num" type="submit" name="submit" class="submit-button">Submit</button>';
        echo '</div>';
        echo '</div>';
    } else {
        echo 'No floor selected.';
    }
?>
