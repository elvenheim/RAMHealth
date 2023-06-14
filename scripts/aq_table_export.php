<?php
    require_once('building_head_connect.php');

    // Retrieve the selected floor and room values from GET parameters
    $selectedFloor = $_GET['floor'];
    $selectedRoom = $_GET['room'];

    // Set the appropriate headers for CSV file
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="exported_tables.csv"');

    // Create a file pointer connected to PHP output
    $output = fopen('php://output', 'w');

    // Iterate over the table names array
    foreach ($tableNames as $tableName) {
        // Build the SQL query with filter conditions
        $query = "SELECT * FROM $tableName";

        // Add the filter conditions for floor and room
        if (!empty($selectedFloor)) {
            $query .= " WHERE floor = '$selectedFloor'";
            if (!empty($selectedRoom)) {
                $query .= " AND room = '$selectedRoom'";
            }
        } elseif (!empty($selectedRoom)) {
            $query .= " WHERE room = '$selectedRoom'";
        }

        // Fetch data from the table with the filter conditions
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