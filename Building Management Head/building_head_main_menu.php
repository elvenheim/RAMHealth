<?php require_once('building_head_connect.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RAM Health</title>   
    <link rel="stylesheet" href="../Building Management Head/BMH Design/building_main_menu.css">
    <link rel="shortcut icon" href="../favicons/favicon.ico"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.3.0/css/all.css">
    <script src="../Building Management Head/building_head.js"></script>
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
                <div class="greet-user">
                    <span>Please choose which parameter you want to view.</span>
                </div>
                <div class="role-list-card">
                    <div class="roles">
                        <div class="role-button" onclick="location.href='building_head.php';">
                            <a class="role-link">
                                <img src='../images/air_quality_icon.svg' class='role-icon'><br>
                                Air Quality
                            </a>
                        </div>
                        <div class="role-button" onclick="location.href='building_head_energy_main.php';">
                            <a class="role-link">
                                <img src='../images/energy_consumption_icon.svg' class='role-icon'><br>
                                Energy Consumption
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>