<?php require_once('air_technician_connect.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RAM Health</title>
    <link rel="stylesheet" href="../Air Quality Technician/AQ Tech Design/air_technician.css">
    <link rel="stylesheet" href="../Air Quality Technician/AQ Tech Design/Sensors/aq_content_deleted_sensors.css">
    <link rel="shortcut icon" href="../favicons/favicon.ico"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.3.0/css/all.css">
    <script src="../Air Quality Technician/air_technician.js"></script>
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
                    <span>Parameter Tables</span>
                </a>
                <nav id="sensor-header" class="card-header-indicator-second"></nav>
                <a href="air_technician_sensor_main.php" class = "card-title-second"> 
                    <span>Sensors </span>
                </a>
                <nav id="deleted-sensor-header" class="card-header-indicator-third"></nav>
                <a href="air_technician_deleted_sensor_main.php" class = "card-title-third"> 
                    <span> Deleted Sensors </span>
                </a>
            </nav>
            <div id="deleted-sensor-table" class="content-deleted-sensor">
                <div class="card">
                    <div class="table-button">
                        <button class="refresh-table" onclick="location.reload()"><span class="fas fa-arrows-rotate"></span> Refresh</button>                    
                    </div>
                    <table class = "air-quality-deleted-sensors-table">
                        <thead>
                            <tr>
                                <th><a href="#arrange-floor" onclick="sortDeleteTable(0)">Floor<span class="sort-indicator">&#x25BC</span></a></th>
                                <th><a href="#arrange-room-number" onclick="sortDeleteTable(1)">Room Number<span class="sort-indicator">&#x25BC</span></a></th>
                                <th><a href="#arrange-sensor-id" onclick="sortDeleteTable(2)">Sensor ID<span class="sort-indicator">&#x25BC</span></a></th>
                                <th><a href="#arrange-sensor-name" onclick="sortDeleteTable(3)">Sensor Name<span class="sort-indicator">&#x25BC</span></a></th>
                                <th><a href="#arrange-sensor-type" onclick="sortDeleteTable(4)">Sensor Type<span class="sort-indicator">&#x25BC</span></a></th>
                                <th><a href="#arrange-date-added" onclick="sortDeleteTable(5)">Date Added<span class="sort-indicator">&#x25BC</span></a></th>
                                <th><a href="#arrange-deleted-at" onclick="sortDeleteTable(6)">Deleted At<span class="sort-indicator">&#x25BC</span></a></th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id = "table-body-sensor">
                            <?php include 'air_technician_deleted_sensor_table.php'; ?>
                        </tbody>
                    </table>    
                    <?php include '../Air Quality Technician/AQ Tech Design/AQ Tech Pagination/aq_tech_deleted_sensor_pagination.php'; ?>
                </div>
            </div>
        </div>
    </body>
</html>