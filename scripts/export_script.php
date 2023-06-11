<?php
    session_start();
    $host = "localhost";
    $user = "root";
    $password = "";
    $db_name = "ramhealth";

    $con = mysqli_connect($host, $user, $password, $db_name) or die("Failed to connect with MySQL: " . mysqli_connect_error());

    // Fetch table names from the query parameter
    $tables = $_GET['table'];

    // Split the table names into an array
    $tableNames = explode(',', $tables);

    // Set the appropriate headers for CSV file
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="exported_tables.csv"');

    // Create a file pointer connected to PHP output
    $output = fopen('php://output', 'w');

    // Iterate over the table names array
    foreach ($tableNames as $tableName) {
        // Fetch data from the table
        $query = "SELECT * FROM $tableName";
        $result = mysqli_query($con, $query);

        // Write column headers only for the first table
        if ($tableName === $tableNames[0]) {
            $columnNames = [];
            while ($column = mysqli_fetch_field($result)) {
                $columnNames[] = $column->name;
            }
            fputcsv($output, $columnNames);
        }

        // Write data rows
        while ($row = mysqli_fetch_assoc($result)) {
            fputcsv($output, $row);
        }

        // Clean up
        mysqli_free_result($result);
    }

    // Close the file pointer
    fclose($output);

    // Clean up
    mysqli_close($con);
    exit();
?>
