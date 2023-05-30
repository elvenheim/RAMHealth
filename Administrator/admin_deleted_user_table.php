<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
function restoreRow(delemployeeId) {
  if (confirm("Are you sure you want to restore this user " + delemployeeId + "?")) {
      var xhr = new XMLHttpRequest();
      xhr.open("POST", "admin_restore_user.php", true);
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      xhr.onreadystatechange = function() {
          if (xhr.readyState == 4) {
                if (xhr.status == 200) {
                    alert("User has been successfully restored.");
                    alert("Error deleting user: " + xhr.responseText);
                    location.reload();
                } else {
                    alert("Error deleting user: " + xhr.responseText);
                }
            }
      };
    xhr.send("deleted_employee_id=" + delemployeeId);
  }
}
</script>

<?php 
    require_once('admin_connect.php');
    
    $rows_per_page = 10;

    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

    $offset = ($page - 1) * $rows_per_page;

    $count_query = "SELECT COUNT(*) as count FROM deleted_users";
    $count_result = mysqli_query($con, $count_query);
    $count_row = mysqli_fetch_assoc($count_result);
    $total_rows = $count_row['count'];

    $total_pages = ceil($total_rows / $rows_per_page);

    $sql = "SELECT du.*, u.user_role, GROUP_CONCAT(r.role_name ORDER BY r.role_name SEPARATOR ', ') AS role_names
            FROM deleted_users du
            JOIN user u ON u.deleted_employee_id = du.deleted_employee_id
            JOIN role_type r ON FIND_IN_SET(r.role_id, u.user_role) > 0
            GROUP BY du.deleted_employee_id
            ORDER BY du.deleted_employee_id
            LIMIT $offset, $rows_per_page";
    
    $result_table = mysqli_query($con, $sql);
    
    if ($total_rows == 0) {
      echo '<span class ="table-no-record"> No users are deleted in the database...' . "</span>" ;
    } else{
        while ($row = mysqli_fetch_assoc($result_table)) {
          echo "<tr>";
          echo '<td style="min-width: 100px; max-width: 100px;">' . $row['deleted_employee_id'] . "</td>";
          echo '<td style="min-width: 150px; max-width: 150px;">' . $row['deleted_employee_fullname'] . "</td>";
          echo '<td style="min-width: 100px; max-width: 100px;">' . $row['deleted_employee_email'] . "</td>";
          echo '<td style="min-width: 250px; max-width: 250px;">' . implode(', ', explode(',', $row['role_names'])) . '</td>';
          echo '<td style="min-width: 100px; max-width: 100px;">' . $row['deleted_employee_create_at'] . "</td>";
          echo '<td style="min-width: 100px; max-width: 100px;">' . $row['employee_delete_at'] . "</td>";
          echo '<td class="action-buttons">';
          echo '<div>';
          echo '<button class="restore-button" type="button" onclick="restoreRow(' . $row['deleted_employee_id'] . ')"> 
                  <i class="fas fa-rotate-left"></i></button>';
          echo '</div>';
          echo "</td>";     
          echo "</tr>";
      }
    }
?>