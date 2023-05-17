<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>

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

    // $sql = "SELECT u.*, ul.employee_fullname, ul.employee_email, 
    //           ul.employee_create_at, GROUP_CONCAT(r.role_name SEPARATOR ', ') 
    //         AS role_names
    //         FROM user u
    //         JOIN user_list ul ON u.employee_id = ul.employee_id
    //         JOIN role_type r ON FIND_IN_SET(r.role_id, u.user_role) > 0
    //         GROUP BY ul.employee_id
    //         ORDER BY ul.employee_id ASC
    //         LIMIT $offset, $rows_per_page
    //         ";

    $sql = "SELECT * FROM deleted_users GROUP BY user_id";
            
    $result_table = mysqli_query($con, $sql);
    
    if ($total_rows == 0) {
      echo '<span class ="table-no-record"> No users are registered in the database...' . "</span>" ;
    } else{
      while ($row = mysqli_fetch_assoc($result_table)) {
        echo "<tr>";
        echo '<td style="min-width: 100px; max-width: 100px;">' . $row['user_id'] . "</td>";
        echo '<td style="min-width: 150px; max-width: 150px;">' . $row['user_fullname'] . "</td>";
        echo '<td style="min-width: 100px; max-width: 100px;">' . $row['user_email'] . "</td>";
        echo '<td style="min-width: 250px; max-width: 250px;">' . implode(', ', explode(',', $row['user_role'])) . "</td>";
        echo '<td style="min-width: 100px; max-width: 100px;">' . $row['user_create_at'] . "</td>";
        echo '<td style="min-width: 100px; max-width: 100px;">' . $row['user_delete_at'] . "</td>";
        echo "</tr>";
    }
    }
?>
