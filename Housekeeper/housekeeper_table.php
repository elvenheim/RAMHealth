<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>    
    function deleteRow(roomNum) {
    if (confirm("Are you sure you want to delete this room?")) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "housekeep_delete_room.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                alert("Room has been successfully deleted.");
                window.location.reload();
            }
        };
        xhr.send("room_num=" + roomNum);
    }

    function deleteRow(userId) {
        if (confirm("Are you sure you want to delete this user?")) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "admin_delete_user.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    alert("User has been successfully deleted.");
                    window.location.reload();
                }
            };
            xhr.send("user_id=" + userId);
        }
    }
}
</script>

<?php
    require_once('housekeep_connect.php');
    
    $rows_per_page = 10;

    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

    $offset = ($page - 1) * $rows_per_page;

    $count_query = "SELECT COUNT(*) as count FROM room_number";
    $count_result = mysqli_query($con, $count_query);
    $count_row = mysqli_fetch_assoc($count_result);
    $total_rows = $count_row['count'];

    $total_pages = ceil($total_rows / $rows_per_page);

    // Fetch data from the database
    $sql = "SELECT * FROM room_number LIMIT $offset, $rows_per_page";
    $result_table = mysqli_query($con, $sql);
        
    // Loop through the data and create table rows
    while ($row = mysqli_fetch_assoc($result_table)){
        echo "<tr>";
        echo '<td class="delete-button-row">';
        echo '<a href="housekeeper.php">
            <button class="delete-button" type="button"
            onclick="deleteRow(\'' . $row['room_num'] . '\')"> 
            <i class="fas fa-trash"></i>
            </button>
            </a>';
        echo "</td>";
        // Building Floor

        echo "<td>";
        $floor_names = [
            1 => 'Ground Floor',
            2 => '2nd',
            3 => '3rd',
        ];
    
        $floor = $row['bldg_floor'];
    
        if ($floor > 3) {
            $floor_names[$floor] = "{$floor}th";
        } elseif ($floor < 0) {
            $positive_floor = abs($floor);
            $floor_names[$floor] = "B{$positive_floor}";
        }
        echo $floor_names[$floor];
        echo "</td>";

        //Other table contents
        echo "<td>" . $row['room_num'] . "</td>";
        echo "<td>" . $row['room_name'] . "</td>";
        echo "<td>" . $row['room_type'] . "</td>";
        echo "</td>";
        echo "<td>" . $row['room_added_at'] . "</td>";
        echo "</tr>";
    }
    
    echo "<div class='pagination'>";
    if ($total_pages > 1) {
        $start_page = max(1, $page - 2);
        $end_page = min($total_pages, $start_page + 4);
        if ($end_page - $start_page < 4 && $start_page > 1) {
            $start_page = max(1, $end_page - 4);
        }
        echo "<a href='?page=" . max(1, $page - 1) . "'" . 
            ($page == 1 ? " class='disabled'" : "") . ">Prev</a>";
        for ($i = $start_page; $i <= $end_page; $i++) {
            echo "<a href='?page=$i'" . ($page == $i ? " class='active'" : "") . ">$i</a>";
        }
        echo "<a href='?page=" . min($total_pages, $page + 1) . "'" . 
            ($page == $total_pages ? " class='disabled'" : "") . ">Next</a>";
    }
    echo "</div>";
?>