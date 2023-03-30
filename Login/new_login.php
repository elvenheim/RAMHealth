<?php 
   $host = "127.0.0.1";
   $user = "root";
   $password = "";
   $db_name = "ramhealth";
   
   $con = mysqli_connect($host , $user , $password , $db_name);
   mysqli_select_db($con, $db_name);
   if(mysqli_connect_errno())
   {
    die("Failed to connect with MySQL :".mysqli_connect_errno());
   }
?>