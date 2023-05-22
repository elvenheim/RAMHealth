<?php
    require_once('home_connect.php');
    
    if (isset($_SESSION['employee_id'])) {
        $stmt = $con->prepare("SELECT employee_fullname FROM user_list WHERE employee_id = ?");
        $stmt->bind_param("i", $_SESSION['employee_id']);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $_SESSION['employee_fullname'] = $row['employee_fullname'];
        }
    }
    echo 'Welcome to'; 
    echo '<span class = "website-name"> RAM Health</span>, ';
    echo '<span class = "employee-name">';
    echo $_SESSION['employee_fullname'];
    echo '</span>';
?>