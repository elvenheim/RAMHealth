<?php 
    require_once('admin_connect.php');

    $roleIdsQuery = "SELECT role_id, role_name FROM role_type";
    $roleIdsResult = mysqli_query($con, $roleIdsQuery);
    
    echo '<label for="role_name">Roles:</label>';
    echo '<div class="checkbox-container">';
    while ($row = mysqli_fetch_assoc($roleIdsResult)) {
        echo '<div>';
        echo '<input type="checkbox" id="role_name_' . $row['role_id'] . '" name="role_name[]" value="' . $row['role_id'] . '">';
        echo '<label for="role_name_' . $row['role_id'] . '">' . $row['role_name'] . '</label>';
        echo '</div>';
    }
    echo '</div>';
?>
