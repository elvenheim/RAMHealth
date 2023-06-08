<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
function deleteRow(roomNum) {
    if (confirm("Do you want to delete this room?")) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "housekeep_delete_room_table.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                alert("Room has been successfully deleted.");
                location.reload();
            }
        };
        xhr.send("room_num=" + roomNum);
    }
}

function editRow(roomNum) {
    if (confirm("Do you want to edit this room?")) {
        // Assuming you have a form to edit the room details
        var form = document.createElement("form");
        form.setAttribute("method", "post");
        form.setAttribute("action", "fetch_room_details.php"); // Replace with your edit page URL
        
        // Create a hidden input field to pass the room number
        var input = document.createElement("input");
        input.setAttribute("type", "hidden");
        input.setAttribute("name", "room_num");
        input.setAttribute("value", roomNum);
        
        // Append the input field to the form
        form.appendChild(input);
        
        // Append the form to the document body
        document.body.appendChild(form);
        
        // Submit the form
        form.submit();
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
    $sql = "SELECT rn.*, bldg.bldg_floor_name 
            FROM room_number rn 
            JOIN building_floor bldg ON rn.bldg_floor = bldg.building_floor
            ORDER BY bldg.building_floor ASC
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
            echo '<td style="min-width: 120px; max-width: 120px;">' . ($row['room_name'] ? $row['room_name'] : 'N/A') . "</td>";
            echo '<td style="min-width: 100px; max-width: 100px;">' . $row['room_added_at'] . "</td>";
            echo '<td class="action-buttons">';
            echo '<div>';
            echo '<button class="edit-button" type="button" onclick="editRow(\'' . $row['room_num'] . '\')">';
            echo '<i class="fas fa-edit"></i>';
            echo '</button>';
            echo '<button class="delete-button" type="button" onclick="deleteRow(\'' . $row['room_num'] . '\')">'; 
            echo '<i class="fas fa-trash"></i>';
            echo '</button>';
            echo '</div>';
            echo '</td>';
            echo '</tr>';
        }
    }
?>