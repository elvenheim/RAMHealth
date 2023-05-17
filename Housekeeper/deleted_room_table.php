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
    $sql = "SELECT drn.*, bflr.bldg_floor_name
            FROM deleted_room_num drn
            JOIN building_floor bflr ON drn.bldg_floor = bflr.building_floor
            ORDER BY bldg_floor ASC
            LIMIT $offset, $rows_per_page";
    $result_table = mysqli_query($con, $sql);
        
    // Loop through the data and create table rows
    if ($total_rows == 0) {
        echo '<span class ="table-no-record"> No rooms are deleted in the database...' . "</span>" ;
    } else{
        while ($row = mysqli_fetch_assoc($result_table)){
            echo "<tr>";
            echo '<td style="min-width: 100px; max-width: 100px;">' . $row['bldg_floor_name'] . "</td>";
            echo '<td style="min-width: 100px; max-width: 100px;">' . $row['room_num'] . "</td>";
            echo '<td style="min-width: 100px; max-width: 100px;">' . $row['room_type'] . "</td>";
            echo '<td style="min-width: 120px; max-width: 120px;">' . $row['room_name'] . "</td>";
            echo '<td style="min-width: 100px; max-width: 100px;">' . $row['room_added_at'] . "</td>";
            echo '<td style="min-width: 80px; max-width: 80px;">' . $row['room_delete_at'] . "</td>";
            echo '<td class="action-buttons">';
            echo '<div>';
            echo '<button class="restore-button" type="button" onclick="restoreRow(\'' . $row['room_num'] . '\')"> 
                    <i class="fas fa-rotate-left"></i></button>';
            echo '</div>';
            echo "</td>";                
            echo "</tr>";
        }
    }
?>