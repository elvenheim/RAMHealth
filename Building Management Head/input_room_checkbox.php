<?php 
    require_once('building_head_connect.php');

    if (isset($_POST['selected_floor'])) {
        $selectedFloor = $_POST['selected_floor'];
        
        $roomQuery = "SELECT room_num FROM room_number WHERE bldg_floor = ?";
        $stmt = mysqli_prepare($con, $roomQuery);
        mysqli_stmt_bind_param($stmt, 's', $selectedFloor);
        mysqli_stmt_execute($stmt);
        $roomResult = mysqli_stmt_get_result($stmt);
        
        echo '<form method="POST">';
        echo '<label for="room_number">Room:</label>';
        echo '<div class="dropdown">';
        echo '<select id="room_number" name="room_number" onchange="this.form.submit()">'; // Add onchange event to submit the form
        echo '<option value="">- Select Room -</option>'; // Add a default option

        while ($row = mysqli_fetch_assoc($roomResult)) {
            $isSelected = isset($_POST['room_number']) && $_POST['room_number'] == $row['room_num'] ? 'selected' : '';
            echo '<option value="' . $row['room_num'] . '" ' . $isSelected . '>' . $row['room_num'] . '</option>';
        }

        // Store the selected room number in the session
        $_SESSION['selected_rooms'] = isset($_POST['room_number']) ? $_POST['room_number'] : '';

        echo '</select>';
        echo '</div>';
        echo '</form>';
    } else {
        echo 'No floor selected.';
    }
?>
