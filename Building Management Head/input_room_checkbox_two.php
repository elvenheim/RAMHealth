<?php
    require_once('building_head_connect.php');

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
        echo '-Select Room-';
        echo '</button>';
        echo '<div class="dropdown-menu" id="room-number-menu">';
        echo '<label class="select-instruct">-Select upto 12 Rooms-</label>';
        echo '<div class="dropdown-item">';
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

        echo '<button button id="submit-room-num" type="button" class="submit-button" onclick="submitAll()">SUBMIT</button>';
        echo '</div>';
        echo '</div>';
    } else {
        echo 'No floor selected';
    }
?>

<script>
    document.addEventListener('click', function(event) {
        var dropdownMenu = document.getElementById('room-number-menu');
        var dropdownButton = document.getElementById('room-number-dropdown');
        if (!dropdownButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
            dropdownMenu.classList.remove('show');
        }
    });

    function toggleDropdown() {
        var menu = document.getElementById('room-number-menu');
        menu.classList.toggle('show');
    }

    function updateCheckboxCount() {
        var checkboxes = document.getElementsByName('room_number[]');
        var selectedCount = 0;
        for (var i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i].checked) {
                selectedCount++;
            }
        }
        return selectedCount;
    }

    function checkboxClickHandler() {
        var selectedCount = updateCheckboxCount();
        var checkboxes = document.getElementsByName('room_number[]');
        for (var i = 0; i < checkboxes.length; i++) {
            checkboxes[i].disabled = (selectedCount >= 12 && !checkboxes[i].checked);
        }
    }

    function submitRoomNumbers() {
        var selectedRooms = $('input[name="room_number[]"]:checked').map(function() {
            return $(this).val();
        }).get();

        $.ajax({
            type: 'POST',
            url: 'refresh_pie_chart.php',
            data: { room_number: selectedRooms },
            success: function(response) {
                $('#refreshPieOne').html(response);
            }
        });
    }

    function submitRoomNumbersBar(){
        var selectedRooms = $('input[name="room_number[]"]:checked').map(function() {
            return $(this).val();
        }).get();

        $.ajax({
            type: 'POST',
            url: 'refresh_bar_chart.php',
            data: { room_number: selectedRooms },
            success: function(response) {
                $('#refreshBarOne').html(response);
            }
        });
    }

    function submitEnergyGauge(){
        var selectedRooms = $('input[name="room_number[]"]:checked').map(function() {
            return $(this).val();
        }).get();

        $.ajax({
            type: 'POST',
            url: 'refresh_energy_gauge.php',
            data: { room_number: selectedRooms },
            success: function(response) {
                $('#refreshEnergyGauge').html(response);
            }
        });
    }

    function submitAll() {
        var selectedRooms = $('input[name="room_number[]"]:checked').map(function() {
            return $(this).val();
        }).get();

        if (selectedRooms.length <= 12) {
            submitRoomNumbers();
            submitRoomNumbersBar();
            submitEnergyGauge();
        } else {
            alert('You can only select up to 12 rooms.');
        }
    }
</script>