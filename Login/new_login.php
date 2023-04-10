<?php 
   $host = "127.0.0.1";
   $user = "root";
   $password = "";
   $db_name = "ramhealth";
   
   $con = mysqli_connect($host , $user , $password , $db_name) 
   or 
   die("Failed to connect with MySQL: " . mysqli_connect_error());
?>
