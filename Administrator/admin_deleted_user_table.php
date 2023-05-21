<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>

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

    $sql = "SELECT du.*, GROUP_CONCAT(r.role_name SEPARATOR ', ') AS role_names
            FROM deleted_users du 
            JOIN role_type r ON FIND_IN_SET(r.role_id, du.user_role) > 0
            GROUP BY user_id ORDER BY user_id ASC
            LIMIT $offset, $rows_per_page";
            
    $result_table = mysqli_query($con, $sql);
    
    if ($total_rows == 0) {
      echo '<span class ="table-no-record"> No users are deleted in the database...' . "</span>" ;
    } else{
      while ($row = mysqli_fetch_assoc($result_table)) {
        echo "<tr>";
        echo '<td style="min-width: 100px; max-width: 100px;">' . $row['user_id'] . "</td>";
        echo '<td style="min-width: 150px; max-width: 150px;">' . $row['employee_fullname'] . "</td>";
        echo '<td style="min-width: 100px; max-width: 100px;">' . $row['employee_email'] . "</td>";

        $roleNames = explode(',', $row['role_names']);
        sort($roleNames);
        $sortedRoleNames = implode(', ', $roleNames);
        echo '<td style="min-width: 250px; max-width: 250px;">' . $sortedRoleNames . "</td>";

        echo '<td style="min-width: 100px; max-width: 100px;">' . $row['employee_create_at'] . "</td>";
        echo '<td style="min-width: 100px; max-width: 100px;">' . $row['user_delete_at'] . "</td>";
        echo '<td class="action-buttons">';
        echo '<div>';
        echo '<button class="restore-button" type="button" onclick="restoreRow(\'' . $row['user_id'] . '\')"> 
                <i class="fas fa-rotate-left"></i></button>';
        echo '</div>';
        echo "</td>";     
        echo "</tr>";
    }
    }
?>