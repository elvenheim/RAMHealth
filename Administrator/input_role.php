<?php 
    require_once('admin_connect.php');

    $roleIdsQuery = "SELECT role_id, role_name FROM role_type";
    $roleIdsResult = mysqli_query($con, $roleIdsQuery);
    
    echo '<label for="role_name">Role Name:</label>';
    echo '<select id="role_name" name="role_name" class="role_name" required>';
    echo '<option value="" disabled selected>-Select Role-</option>';
    while ($row = mysqli_fetch_assoc($roleIdsResult)) {
        echo '<option value="' . $row['role_id'] . '">' . $row['role_name'] . '</option>';
    }
    echo '</select><br>';
?>
