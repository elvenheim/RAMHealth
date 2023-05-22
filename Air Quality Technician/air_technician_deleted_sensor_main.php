<?php require_once('air_technician_connect.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RAM Health</title>
    <link rel="stylesheet" href="air_technician.css">>
    <link rel="stylesheet" href="aq_content_one.css">
    <link rel="stylesheet" href="aq_content_two.css">  
    <link rel="stylesheet" href="aq_content_three.css">      
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
                <a href="../Air Quality Technician/air_technician.php" class = "card-title">
                    <span> Air Quality Parameter Table </span>
                </a>
                <nav id="sensor-header" class="card-header-indicator-second"></nav>
                <a href="../Air Quality Technician/air_technician_sensor_main.php" class = "card-title-second"> 
                    <span> Air Quality Sensors </span>
                </a>
                <nav id="deleted-sensor-header" class="card-header-indicator-third"></nav>
                <a href="../Air Quality Technician/air_technician_deleted_sensor_main.php" class = "card-title-third"> 
                    <span> Deleted Air Quality Sensors </span>
                </a>
            </nav>
            <div id="deleted-sensor-table" class="content-deleted-sensor">
                <div class="card">
                    <table class = "air-quality-deleted-sensors-table">
                        <thead>
                            <tr>
                                <th>Room Number</th>
                                <th>Sensor</th>
                                <th>Sensor Type</th>
                                <th>Date Added</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id = "table-body-sensor">
                            <?php include 'air_technician_sensor_table.php'; ?>
                        </tbody>
                    </table>    
                </div>
            </div>
        </div>
    </body>
</html>