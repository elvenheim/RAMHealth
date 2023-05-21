<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
  $('.edit-button').click(function() {
    var roomId = $(this).data('room-id');
    // Use the roomId to perform the necessary actions for editing
    // For example, you can display a popup or form for editing
    // and pre-fill the form fields with existing data for the specific room ID
  });
});
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
    $sql = "SELECT rn.*, bldg.bldg_floor_name 
            FROM room_number rn 
            JOIN building_floor bldg ON rn.bldg_floor = bldg.building_floor
            LIMIT $offset, $rows_per_page";
    $result_table = mysqli_query($con, $sql);
        
    // Loop through the data and create table rows
    if ($total_rows == 0) {
        echo '<span class ="table-no-record"> No rooms are registered in the database...' . "</span>" ;
    } else{
        while ($row = mysqli_fetch_assoc($result_table)){
            echo "<tr>";
            echo '<td style="min-width: 100px; max-width: 100px;">' . $row['bldg_floor_name'] . "</td>";
            echo '<td style="min-width: 100px; max-width: 100px;">' . $row['room_num'] . "</td>";
            echo '<td style="min-width: 100px; max-width: 100px;">' . $row['room_type'] . "</td>";
            echo '<td style="min-width: 120px; max-width: 120px;">' . $row['room_name'] . "</td>";
            echo '<td style="min-width: 100px; max-width: 100px;">' . $row['room_added_at'] . "</td>";
            echo '<td class="action-buttons">';
            echo '<div>';
            echo '<button class="edit-button" type="button" onclick="editRow(\'' . $row['room_num'] . '\')"> 
                    <i class="fas fa-edit"></i></button>';
            echo '<button class="delete-button" type="button" onclick="deleteRow(\'' . $row['room_num'] . '\')"> 
                <i class="fas fa-trash"></i></button>';
            echo '</div>';
            echo "</td>";
            echo "</tr>";
        }
    }
?>