<?php
    include('new_login.php');
    $username = $_POST['email'];
    $password = $_POST['password'];

    // to prevent from mysqli injection
    $username = stripcslashes($username);
    $password = stripcslashes($password);

    $username = mysqli_real_escape_string($con, $username);
    $password = mysqli_real_escape_string($con, $password);

    $sql = "select * from user where user_email = '$username' and user_password = '$password'" ;
    $result = mysqli_query($con , $sql);
    $row = mysqli_fetch_array($result , MYSQLI_ASSOC);
    $count = mysqli_num_rows($result);

    if($count == 1)
    {
        header("Location: ../Administrator/admin.html");
        exit;
    }else
    {
        header("Location: failed.html");
        exit;
    }
?>