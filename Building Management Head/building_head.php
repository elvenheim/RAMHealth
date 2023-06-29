<?php require_once('building_head_connect.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RAM Health</title>   
    <link rel="stylesheet" href="../Building Management Head/BMH Design/building_head.css">
    <link rel="stylesheet" href="../Building Management Head/BMH Design/building_head_ac_dropdown.css">
    <link rel="stylesheet" href="../Building Management Head/BMH Design/building_head_air_quality.css">

    <link rel="shortcut icon" href="../favicons/favicon.ico"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.3.0/css/all.css">
    <script src="../Building Management Head/building_head.js"></script>
    <script src="../Building Management Head/building_head_export.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.3.0/raphael.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/justgage/1.6.1/justgage.min.js"></script>
    <script src="https://unpkg.com/xlsx/dist/xlsx.full.min.js"></script>
</head>
    <body class="building-head-main">
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
        <div id="user-list-table" class="content-one">
            <div class="card">
                <div class = "table-button">
                    <div class="back-class-btn">
                        <button id="back-button" class="back-button" onclick="location.href='building_head_main_menu.php';">
                            <span class="fas fa-arrow-left"></span> Go Back </button>
                    </div>
                    <div class="filter-table">
                        <div class="dropdown-form">
                            <?php include 'input_floor.php'?>
                        </div>
                        <div id="dropdown-room" class="dropdown-room">
                            <?php include 'input_room_checkbox.php'?>
                        </div>
                    </div>
                    <div class="other-table-button">
                        <button class="refresh-table" onclick="location.reload()">
                            <span class="fas fa-arrows-rotate"></span> Refresh</button>
                        <button id="download-table" class="download-table" onclick="downloadAQExcelTables()">
                            <span class="fas fa-download"></span> Export </button>
                    </div>
                </div>
                <div class="aq-main-contents">
                    <div class="chart-box-one">
                        <div class="chart-box-one-card">
                            <div class="pm-ten-chart">
                                <?php include('../Building Management Head/charts/pm_ten_chart.php')?>
                            </div>
                            <div class="pm-two-five-chart">
                                <?php include('../Building Management Head/charts/pm_two_five_chart.php')?>
                            </div>
                        </div>
                    </div>
                    <div class="chart-box-two">
                        <div class="chart-box-two-card">
                            <div class="pm-zero-one-chart">
                                <?php include('../Building Management Head/charts/pm_zero_one_chart.php')?>
                            </div>
                        </div>
                    </div>
                    <div id="refreshGaugeOne" class="gauge-box-one">
                        <div class="gauge-box-one-card">
                            <div class="pm-ten-gauge-group">
                                <?php include('../Building Management Head/gauges/pm_ten_gauge.php')?>
                            </div>
                            <div class="pm-two-five-gauge-group">
                                <?php include('../Building Management Head/gauges/pm_two_five_gauge.php')?>
                            </div>
                            <div class="pm-zero-one-gauge-group">
                                <?php include('../Building Management Head/gauges/pm_zero_one_gauge.php')?>
                            </div>
                            <div class="gas-gauge-group">
                                <?php include('../Building Management Head/gauges/gas_gauge.php')?>
                            </div>
                        </div>
                    </div>
                    <div id="refreshGaugeTwo" class="gauge-box-two">
                        <div class="gauge-box-two-card">
                            <div class="indoor-temp-gauge-group">
                                <?php include('../Building Management Head/gauges/indoor_temperature_gauge.php')?>
                            </div>
                            <div class="outdoor-temp-gauge-group">
                                <?php include('../Building Management Head/gauges/outdoor_temperature_gauge.php')?>
                            </div>
                            <div class="humidity-gauge-group">
                                <?php include('../Building Management Head/gauges/humidity_gauge.php')?>
                            </div>
                            <div class="aq-summary-group">
                                <?php include('../Building Management Head/aq_summary.php')?>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- user-list-table div ender -->
        </div>
    </body>
</html>