<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
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

function deleteRow(employeeId) {
  // Check if the user being deleted is the current user
  var currentEmployeeId = <?php echo $_SESSION['employee_id']; ?>;
  if (employeeId == currentEmployeeId) {
    alert("You cannot delete your own account.");
    return;
  }

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
      xhr.send("employee_id=" + employeeId);
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

    $sql = "SELECT u.*, ul.employee_fullname, ul.employee_email, 
              ul.employee_create_at, GROUP_CONCAT(r.role_name SEPARATOR ', ') 
            AS role_names
            FROM user u
            JOIN user_list ul ON u.employee_id = ul.employee_id
            JOIN role_type r ON FIND_IN_SET(r.role_id, u.user_role) > 0
            GROUP BY ul.employee_id
            ORDER BY ul.employee_id ASC
            LIMIT $offset, $rows_per_page
            ";
            
    $result_table = mysqli_query($con, $sql);
    
    if ($total_rows == 0) {
      echo '<span class ="table-no-record"> No users are registered in the database...' . "</span>" ;
    } else{
      while ($row = mysqli_fetch_assoc($result_table)) {
        echo "<tr" . ($row['user_status'] == 0 ? " class=\"disabled\"" : '') . ">";
        echo '<td style="min-width: 100px; max-width: 100px;">' . $row['employee_id'] . "</td>";
        echo '<td style="min-width: 150px; max-width: 150px;">' . $row['employee_fullname'] . "</td>";
        echo '<td style="min-width: 100px; max-width: 100px;">' . $row['employee_email'] . "</td>";
        echo '<td style="min-width: 250px; max-width: 250px;">' . implode(', ', explode(',', $row['role_names'])) . "</td>";
        echo '<td style="min-width: 100px; max-width: 100px;">' . $row['employee_create_at'] . "</td>";
        echo '<td style="min-width: 100px; max-width: 100px;">';
        echo '<form class="status-form">';
        echo '<input type="hidden" name="employee_id" value="' . $row['employee_id'] . '">';
        echo '<select name="user_status" onchange="updateStatus(this.form);">';
        echo '<option value="1"' . ($row['user_status'] == 1 ? ' selected' : '') . '>Enabled</option>';
        echo '<option value="0"' . ($row['user_status'] == 0 ? ' selected' : '') . '>Disabled</option>';
        echo '</select>';
        echo '</form>';
        echo "</td>";
        echo '<td class="action-buttons">';
        echo '<div>';
        echo '<button class="edit-button" type="button" onclick="editRow(' . $row['employee_id'] . ')"> 
                <i class="fas fa-edit"></i></button>';
        echo '<button class="delete-button" type="button" onclick="deleteRow(' . $row['employee_id'] . ')"> 
                <i class="fas fa-trash"></i></button>';
        echo '</div>';
        echo "</td>";
        echo "</tr>";
    }
    }
?>
