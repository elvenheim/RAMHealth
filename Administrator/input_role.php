<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $('option').mousedown(function(e) {
    e.preventDefault();
    $(this).prop('selected', !$(this).prop('selected'));
    return false;
});
</script>

<?php 
    require_once('admin_connect.php');

    $roleIdsQuery = "SELECT role_id, role_name FROM role_type";
    $roleIdsResult = mysqli_query($con, $roleIdsQuery);
    
    echo '<label for="role_name">Role:</label>';
    echo '<select id="role_name" name="role_name[]" class="role_name" multiple required>';
    while ($row = mysqli_fetch_assoc($roleIdsResult)) {
        echo '<option value="' . $row['role_id'] . '">' . $row['role_name'] . '</option>';
    }
    echo '</select><br>';
?>
