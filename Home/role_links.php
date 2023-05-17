<?php
    require_once('home_connect.php');

    $user_id = $_SESSION['employee_id'];

    $sql = "SELECT u.*, r.role_name, r.role_url
            FROM user u
            JOIN user_list ul ON u.employee_id = ul.employee_id AND u.employee_id = ul.employee_id
            JOIN role_type r ON u.user_role = r.role_id
            WHERE u.employee_id = '$user_id'
            ORDER BY r.role_id";
                
    $result = mysqli_query($con, $sql);
                
    // Display the roles as links/buttons
    if (mysqli_num_rows($result) > 0) {
        echo "<div class='roles'>";
        while ($row = mysqli_fetch_assoc($result)) {
            $role_name = $row['role_name'];
            $role_url = $row['role_url'];
            echo "<a href='$role_url' class='role-link'>$role_name</a><br>";
        }
        echo "</div>";
    }
?>