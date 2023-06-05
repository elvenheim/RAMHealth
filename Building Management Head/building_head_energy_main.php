<?php require_once('building_head_connect.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RAM Health</title>   
    <link rel="stylesheet" href="../Building Management Head/BMH Design/building_head.css">
    <link rel="stylesheet" href="../Building Management Head/BMH Design/building_head_energy_consumption.css">
    <link rel="shortcut icon" href="../favicons/favicon.ico"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.3.0/css/all.css">
    <script src="../Administrator/admin.js"></script>
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
                <nav class="card-header">
                    <nav id="user-list-table-header" class="card-header-indicator"></nav>
                        <a href="../Building Management Head/building_head.php" class = "card-title">
                            <span> Air Quality</span>
                        </a>
                    <nav id="deleted-user-header" class="card-header-indicator-second"></nav>
                    <a href="../Building Management Head/building_head_energy_main.php" class = "card-title-second"> 
                        <span> Energy Consumption </span>
                    </a>
                </nav>
                <div class="aq-main-contents">
                    <div class="left-gauge-box">
                        <div class="left-gauge-card">
                        </div>
                    </div>

                    <div class="chart-box">
                        <div class="chart-card">
                        </div>
                    </div>

                    <div class="right-gauge-box">
                        <div class="right-gauge-card">
                        </div>
                    </div>
                </div>
            </div> <!-- user-list-table div ender -->
        </div>
    </body>
</html>