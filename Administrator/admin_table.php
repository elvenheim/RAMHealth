<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
  $('select[name="user_status"]').change(function() {
    var form = $(this).parent('form');
    var formData = form.serialize();
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
        }
      },
      error: function(xhr, status, error) {
        console.log('Error: ' + error);
      }
    });
  });
});

function deleteRow(userId) {
  if (confirm("Are you sure you want to delete this user?")) {
      var xhr = new XMLHttpRequest();
      xhr.open("POST", "admin_delete_user.php", true);
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      xhr.onreadystatechange = function() {
          if (xhr.readyState == 4 && xhr.status == 200) {
              alert("User has been deleted successfully.");
              window.location.reload();
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
            ORDER BY u.user_id
            LIMIT $offset, $rows_per_page";
    $result_table = mysqli_query($con, $sql);

    while ($row = mysqli_fetch_assoc($result_table)){
        echo "<tr" . ($row['user_status'] == 0 ? ' class="disabled"' : '') . ">";
        echo '<td class="delete-button-row">';
        echo '<button class="delete-button" type="button" onclick="deleteRow(' . $row['user_id'] . ')"> 
            <i class="fas fa-trash"></i> 
            </button>';
        echo "</td>";
        echo "<td>" . $row['user_id'] . "</td>";
        echo "<td>" . $row['role_name'] . "</td>";
        echo "<td>" . $row['user_fullname'] . "</td>";
        echo "<td>" . $row['user_email'] . "</td>";
        echo "<td>" . $row['user_create_at'] . "</td>";
        echo "<td>";
        echo '<form class="status-form">';
        echo '<input type="hidden" name="user_id" value="' . $row['user_id'] . '">';
        echo '<select name="user_status" onchange="updateStatus(this.form)">';
        echo '<option value="1"' . ($row['user_status'] == 1 ? ' selected' : '') . '>Enabled</option>';
        echo '<option value="0"' . ($row['user_status'] == 0 ? ' selected' : '') . '>Disabled</option>';
        echo '</select>';
        echo '</form>';
        echo "</td>";
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
            ($page == 1 ? "class='disabled'" : "") . ">Prev</a>";
        for ($i = $start_page; $i <= $end_page; $i++) {
            echo "<a href='?page=$i'" . ($page == $i ? " class='active'" : "") . ">$i</a>";
        }
        echo "<a href='?page=" . min($total_pages, $page + 1) . "'" . 
            ($page == $total_pages ? " class='disabled'" : "") . ">Next</a>";
    }
    echo "</div>";

?>