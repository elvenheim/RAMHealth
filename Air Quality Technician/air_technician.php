<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RAM Health</title>
    <link rel="stylesheet" href="air_technician.css">>
    <link rel="stylesheet" href="aq_content_one.css">
    <link rel="stylesheet" href="aq_content_two.css">       
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
            <div id="param-table" class="content-parameter">
                <div class="card">
                    <!-- Selection of Building Floor -->
                        <form class="building-floor-dropdown"> 
                            <span> Building Floor: </span>
                            <input type="hidden" name="user_id">
                                <select name="user_status" onchange="updateStatus(this.form)">
                                    <option value="1">Sample Floor 1</option>
                                    <option value="0">Sample Floor 2</option>
                                </select>
                            </input>
                        </form>
                    <div class = "table-button">
                        <button id="download-table" class="download-table" onclick="downloadExcel()">
                        <span class="fas fa-download"></span> Download 
                        </button>
                        <button class="refresh-table" onclick="location.reload()">
                        <span class="fas fa-arrows-rotate"></span> Refresh
                        </button>
                        <form class="import-table" method="POST" enctype="multipart/form-data">
                        <label class="import-btn"><span class="fas fa-file-import"></span> Import
                        <input type="file" name="csv_file" style="display: none;" required accept=".csv"></label> 
                        </form>
                    </div>
                    <table class = "gas-level-parameters-table">
                        <thead>
                            <tr>
                                <th>Room Number</th>
                                <th>Sensor ID</th>
                                <th>Date</th>
                                <th>Time</th>              
                                <th>Gas Level</th>
                            </tr>
                        </thead>
                        <tbody id = "table-body">
                            <?php include 'air_technician_parameter_table.php'; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>