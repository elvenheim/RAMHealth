<?php 
   session_start();
   $host = "localhost";
   $user = "root";
   $password = "";
   $db_name = "ramhealth";
   
   $con = mysqli_connect($host , $user , $password , $db_name) 
   or 
   die("Failed to connect with MySQL: " . mysqli_connect_error());

   // if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
   //    header("Location: admin.php");
   //    exit;
   //  }
   //  header("Cache-Control: private, max-age=0, no-cache, no-store");
   //  header("Pragma: no-cache");

?>
