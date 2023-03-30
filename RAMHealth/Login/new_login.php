<?php 
    $connection = mysqli_connect("localhost", "root", "");
    $db = mysqli_select_db($connection, 'ramhealth');

    if(isset($_POST['signin']))
    {
        
        $email=$_POST['email'];
        $password=$_POST['password'];
        
        $query = "SELECT * FROM `user` WHERE user_email= '$email' AND user_password= '$password' ";
        $query_run = mysqli_query($connection, $query);
        
        if(mysqli_fetch_array($query_run)>0){
            echo " You Have Successfully Logged in";
            exit();
        }
        else{
            echo " You Have Entered Incorrect Password";
            exit();
        }
            
    }
?>