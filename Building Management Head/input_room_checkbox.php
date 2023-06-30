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
        echo '<label for="room_number">Room: </label>';
        echo '<select id="room_number" name="room_number" class="room_number" 
        onchange="refreshGaugeOne(this.value); refreshGaugeTwo(this.value);
        refreshPieOne(this.value)">';
        echo '<option value="" disabled selected>- Select Room -</option>';

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
        echo '<label for="room_number">No Floor Selected</label>';
    }
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function refreshGaugeOne(roomNumber) {
        $.ajax({
            type: 'POST',
            url: 'refresh_aq_gauge_one.php',
            data: { room_number: roomNumber },
            success: function(response) {
                $('#refreshGaugeOne').html(response);
            }
        });
    }

    function refreshGaugeTwo(roomNumber) {
        $.ajax({
            type: 'POST',
            url: 'refresh_aq_gauge_two.php',
            data: { room_number: roomNumber },
            success: function(response) {
                $('#refreshGaugeTwo').html(response);
            }
        });
    }

    function refreshPieOne(roomNumber) {
        $.ajax({
            type: 'POST',
            url: 'refresh_pie_chart.php',
            data: { room_number: roomNumber },
            success: function(response) {
                $('#refreshPieOne').html(response);
            }
        });
    }
</script>