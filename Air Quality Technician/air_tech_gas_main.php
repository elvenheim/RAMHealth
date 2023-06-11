<?php require_once('air_technician_connect.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RAM Health</title>
    <link rel="stylesheet" href="../Air Quality Technician/AQ Tech Design/air_technician.css">
    <link rel="stylesheet" href="../Air Quality Technician/AQ Tech Design/air_technician_dropdown.css">
    <link rel="stylesheet" href="../Air Quality Technician/AQ Tech Design/Parameters/aq_content_gas.css">
    <link rel="shortcut icon" href="../favicons/favicon.ico"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.3.0/css/all.css">
    <script src="../Air Quality Technician/air_technician.js"></script>
    <script src="../Air Quality Technician/air_technician_table_sort.js"></script>
    <script src="../Air Quality Technician/air_technician_export.js"></script>
    <script src="https://unpkg.com/xlsx/dist/xlsx.full.min.js"></script>
</head>
    <body class="aq-technician-main">
        <nav class="navbar">
            <div class="ram-health-logo">
                <div class="ram-health-title" onclick="location.href='../Home/homepage.php';">
                RAM Health
                </div>
            </div>
            <span id="log_out_dropdown" name="log_out_dropdown" class="log-out-symbol fas fa-power-off" 
                onselectstart="return false;" onclick="collapse_logout()">
            </span>
        </nav>
        <ul id="btn_logout" class="log-out" style="display: none;">
            <form id="logout" name="logout-form" method="post" action="../Login/session_logout.php">
                <button class="logout-button" type="submit" name="logout">
                    <span class="fas fa-power-off"></span>
                    Logout
                </button>
            </form>
        </ul>
        <!-- For the Main Interface Contents -->
        <!-- Air Technician Table -->
        <div class="content"> 
            <nav class="card-header">
                <nav id="param-header" class="card-header-indicator"></nav>
                <a href="air_technician.php" class = "card-title">
                    <span> Parameter Tables </span>
                </a>
                <nav id="sensor-header" class="card-header-indicator-second"></nav>
                <a href="air_technician_sensor_main.php" class = "card-title-second"> 
                    <span> Sensors </span>
                </a>
                <nav id="deleted-sensor-header" class="card-header-indicator-third"></nav>
                <a href="air_technician_deleted_sensor_main.php" class = "card-title-third"> 
                    <span> Deleted Sensors </span>
                </a>
            </nav>
            <div id="gas-level-param-table" class="gas-level-parameter">
                <div class="card">
                    <div class = "table-button">
                        <button id="back-button" class="back-button" onclick="location.href='air_technician.php';">
                            <span class="fas fa-arrow-left"></span> Go Back </button>
                        <button class="refresh-table" onclick="location.reload()">
                            <span class="fas fa-arrows-rotate"></span> Refresh</button>
                        <form id="filter-table-form" method="POST">
                            <div class="filter-table">
                                <div class="dropdown-form">
                                    <?php include 'input_floor.php'?>
                                </div>
                                <div id="dropdown-room" class="dropdown-room">
                                    <?php include 'input_room_checkbox.php'?>
                                </div>
                            </div>
                        </form>
                        <form class="import-table" method="POST" enctype="multipart/form-data" action="../scripts/import_table_aq.php">
                            <label class="import-btn">
                                <span class="fas fa-file-import"></span> Import
                                <input type="hidden" id="table_name" name="table_name" value="aq_gas_level">
                                <input type="file" name="csv_file" style="display: none;" required accept=".csv" onchange="submitForm()">
                            </label>
                        </form>
                        <button id="download-table" class="download-table" onclick="downloadGASExcelTable()">
                            <span class="fas fa-download"></span> Export </button>
                    </div>
                    <table id = 'gas-level-parameters-table' class = 'gas-level-table'>
                        <thead>
                            <tr>
                                <th><a href="#arrange-room-number" onclick="sortAQGasTable(0)">Room Number<span class="sort-indicator">&#x25BC;</span></a></th>
                                <th><a href="#arrange-sensor-id" onclick="sortAQGasTable(1)">Sensor ID<span class="sort-indicator">&#x25BC;</span></a></th>
                                <th><a href="#arrange-sensor-name" onclick="sortAQGasTable(2)">Sensor Name<span class="sort-indicator">&#x25BC;</span></a></th>
                                <th><a href="#arrange-date" onclick="sortAQGasTable(3)">Date<span class="sort-indicator">&#x25BC;</span></a></th>
                                <th><a href="#arrange-time" onclick="sortAQGasTable(4)">Time<span class="sort-indicator">&#x25BC;</span></a></th>
                                <th><a href="#arrange-gas-level" onclick="sortAQGasTable(5)">Gas Level<span class="sort-indicator">&#x25BC;</span></a></th>
                            </tr>
                        </thead>
                        <tbody id = 'table-body'>
                            <?php include 'air_technician_gas_table.php'?>
                        </tbody> 
                    </table>
                    <?php include '../Air Quality Technician/AQ Tech Design/AQ Tech Pagination/gas_pagination.php'; ?>
                </div>
            </div>
        </div>
    </body>
</html>