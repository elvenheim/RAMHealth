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

    if($count > 0){
        switch($row['user_role']){
            case "administrator":
                header('Location:../Administrator/admin.html');
                break;
            case "housekeeper":
                header('Location:../Housekeeper/housekeeper.html');
                break;
            case "air technician":
                //header here
                break;
            case "energy technician":
                //header here
                break;
            case "building head":
                //header here
                break;
            default:
                echo '<script type="text/javascript">alert("Incorrect Email or Password");window.location.href="new_login.html"</script>';
                exit;
            } 
    } else {
        echo '<script type="text/javascript">alert("Incorrect Email or Password");window.location.href="new_login.html"</script>';
        exit;
    }
?>