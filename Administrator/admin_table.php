<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
// function updateTable() {
//     // Get all the updated data in the table
//     var data = [];
//     $('table tr').each(function(i, row){
//         var rowData = {};
//         $(row).find('td[contenteditable=true]').each(function(j, cell){
//             rowData[$(cell).attr('class')] = $(cell).html();
//         });
//         data.push(rowData);
//     });

//     // Show a confirmation message
//     if (window.confirm("Are you sure you want to update the table?")) {
//         // Send the data to the server using Ajax
//         $.ajax({
//             url: 'update_table.php',
//             type: 'POST',
//             data: {data: data},
//             success: function(response) {
//                 if (response.status === 'error') {
//                     console.log('Error: ' + response.message);
//                 } else {
//                     console.log('Table updated successfully');
//                     location.reload();
//                 }
//             },
//             error: function(xhr, status, error) {
//                 console.log('Error: ' + error);
//             }
//         });
//     }
// }

$(document).ready(function() {
  $('select[name="user_status"]').not('.no-color-change').change(function() {
    var form = $(this).parent('form');
    var formData = form.serialize();
    var originalStatus = $(this).data('original-status');
    if (confirm("Are you sure you want to update the user status?")) {
      $.ajax({
        url: 'update_status.php',
        type: 'POST',
        data: formData,
        success: function(response) {
          if (response.status === 'success') {
            var statusSelect = form.find('select[name="user_status"]');
            if (response.user_status == 1) {
              statusSelect.css('background-color', '#646467');
            } else {
              statusSelect.css('background-color', '#ccc');
            }
            statusSelect.data('original-status', response.user_status);
          }
          location.reload();
        },
        error: function(xhr, status, error) {
          console.log('Error: ' + error);
        }
      });
    } else {
      location.reload();
    }
  });
});

function deleteRow(userId) {
  if (confirm("Are you sure you want to delete this user?")) {
      var xhr = new XMLHttpRequest();
      xhr.open("POST", "admin_delete_user.php", true);
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      xhr.onreadystatechange = function() {
          if (xhr.readyState == 4 && xhr.status == 200) {
              alert("User has been successfully deleted.");
              window.location.href = "admin.php";
          }
      };
      xhr.send("user_id=" + userId);
  }
}
</script>

<?php 
    require_once('admin_connect.php');
    
    $rows_per_page = 10;

    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

    $offset = ($page - 1) * $rows_per_page;

    $count_query = "SELECT COUNT(*) as count FROM user";
    $count_result = mysqli_query($con, $count_query);
    $count_row = mysqli_fetch_assoc($count_result);
    $total_rows = $count_row['count'];

    $total_pages = ceil($total_rows / $rows_per_page);

    $sql = "SELECT u.*, r.role_name 
            FROM user u
            JOIN role_type r 
            ON u.user_role = r.role_id
            ORDER BY u.user_id ASC, u.user_status DESC
            LIMIT $offset, $rows_per_page";
    $result_table = mysqli_query($con, $sql);

    while ($row = mysqli_fetch_assoc($result_table)){
        echo "<tr" . ($row['user_status'] == 0 ? ' class="disabled"' : '') . ">";
        echo "<td>" . $row['user_id'] . "</td>";
        echo "<td>" . $row['role_name'] . "</td>";
        echo "<td>" . $row['user_fullname'] . "</td>";
        echo "<td>" . $row['user_email'] . "</td>";
        echo "<td>" . $row['user_create_at'] . "</td>";
        echo "<td>";
        echo '<form class="status-form">';
        echo '<input type="hidden" name="user_id" value="' . $row['user_id'] . '">';
        echo '<select name="user_status" onchange="updateStatus(this.form);">';
        echo '<option value="1"' . ($row['user_status'] == 1 ? ' selected' : '') . '>Enabled</option>';
        echo '<option value="0"' . ($row['user_status'] == 0 ? ' selected' : '') . '>Disabled</option>';
        echo '</select>';
        echo '</form>';
        echo "</td>";
        echo '<td class="action-buttons">';
        echo '<div>';
        echo ' <button class="delete-button" type="button" onclick="deleteRow(' . $row['user_id'] . ')"> 
              <i class="fas fa-trash"></i></button>';
        echo '</div>';
        echo "</td>";
        echo "</tr>";
    }

    echo '<button class="update-button" type="button" onclick="updateTable()">Update</button>';

?>