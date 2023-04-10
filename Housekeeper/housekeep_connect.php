<?php 
   $host = "localhost";
   $user = "root";
   $password = "";
   $db_name = "ramhealth";
   
   $conn = mysqli_connect($host , $user , $password , $db_name) 
   or 
   die("Failed to connect with MySQL: " . mysqli_connect_error());
?>
