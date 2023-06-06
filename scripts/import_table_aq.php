<?php
session_start();
$host = "localhost";
$user = "root";
$password = "";
$db_name = "ramhealth";

$con = mysqli_connect($host, $user, $password, $db_name)
or
die("Failed to connect with MySQL: " . mysqli_connect_error());

// Disable foreign key checks
mysqli_query($con, 'SET FOREIGN_KEY_CHECKS = 0');

// Get the table name from the form submission
$tableName = $_POST['table_name'];

// Truncate the table to empty its contents
$query = "TRUNCATE TABLE $tableName";
mysqli_query($con, $query);

// Import the CSV file into the table
$importSuccessful = false;
if ($_FILES['csv_file']['size'] > 0) {
    $file = $_FILES['csv_file']['tmp_name'];
    $handle = fopen($file, "r");
    $header = true;

    while (($data = fgetcsv($handle, 1000, ",")) !== false) {
        if ($header) {
            $header = false;
            continue;
        }

        // Prepare and execute the INSERT query dynamically
        $numColumns = count($data);
        $placeholders = array_fill(0, $numColumns, '?');
        $insertQuery = "INSERT INTO $tableName VALUES (" . implode(',', $placeholders) . ")";
        $stmt = mysqli_prepare($con, $insertQuery);
        mysqli_stmt_bind_param($stmt, str_repeat('s', $numColumns), ...$data);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    fclose($handle);
    $importSuccessful = true;
}

// Enable foreign key checks
mysqli_query($con, 'SET FOREIGN_KEY_CHECKS = 1');

mysqli_close($con);

$referrer = $_SERVER['HTTP_REFERER'];

if ($importSuccessful) {
    echo "<script>alert('Import successful'); window.location.href = '$referrer';</script>";
    exit;
} else {
    echo "<script>alert('Import unsuccessful'); window.location.href = '$referrer';</script>";
    exit;
}
?>