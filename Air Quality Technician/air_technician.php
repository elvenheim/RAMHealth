<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Air Quality Technician</title>
    <link rel="stylesheet" href="air_technician.css">
    <link rel="stylesheet" href="air_technician_two.css">
    <link rel="shortcut icon" href="../favicons/favicon.ico"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.3.0/css/all.css">
</head>
    <body class="admin-main">
        <div class="wrapper">
            <nav class="main-header navbar navbar-expand navbar-gray">
                <div class="apc-logo">
                    <img src="https://signin.apc.edu.ph/images/logo.png" width="55px"/>
                </div>
                <div class="ram-health-title">
                    RAM Health
                </div>
                <!-- FOR LOG OUT -->
                <span id="user_full_name" name="full_name" class="log-out-name" 
                onselectstart="return false;" onclick="collapse_logout()">
                    <?php include 'air_technician_name.php';?>
                </span>
                <span id="user_role_type" name="role_type" class="role-type" onselectstart="return false;">
                    <?php include 'air_technician_role.php';?>
                </span>
                </div>
                <ul id="btn_logout" class="log-out">
                    <form name="logout-form" method="post">
                        <button class="logout-button" type="button" onclick="logout()">
                            <span class="fas fa-power-off"></span>
                            Logout
                        </button>
                    </form>
                </ul>
            </nav>
        </div>
        <!-- For the Main Interface Contents -->
        <!-- Air Technician Table -->
        <div class="content">
            <div class="card">
                <nav class="card-header-indicator">
                </nav>
                <nav class="card-header-indicator-second">
                </nav>
                <nav class="card-header">
                </nav>
                <a class = "card-title">
                    <span>
                        Air Quality Table
                    </span>
                </a>
                <a class = "card-title-second">
                    <span>
                        Air Quality Sensors
                    </span>
                </a>

                <!-- Selection of Building Floor -->
                <form class="building-floor-dropdown">
                    <span>
                        Building Floor:
                    </span>
                    <input type="hidden" name="user_id">
                        <select name="user_status" onchange="updateStatus(this.form)">
                            <option value="1">Sample Floor 1</option>
                            <option value="0">Sample Floor 2</option>
                        </select>
                    </input>
                </form>
                <!-- Selection of Building Floor -->

                <div class = "table-button">
                    <button id="download-table" class="download-table" onclick="adduser_popup()">
                        <span class="fas fa-download"></span>
                        Download
                    </button>
                    <button class="refresh-table" onclick="location.reload()">
                        <span class="fas fa-arrows-rotate"></span>
                        Refresh
                    </button>
                    <form class="import-table" method="POST" enctype="multipart/form-data">
                        <label class="import-btn">
                        <span class="fas fa-file-import"></span>
                        Import
                        <input type="file" name="csv_file" style="display: none;" required accept=".csv">
                        </label>
                    </form>
                </div>
                <table class = "air-quality-parameters-table">
                    <thead>
                        <tr>
                            <!-- <th class = "delete-column"></th> for sensors table-->
                            <!-- <th>Room Number</th> still not linked -->
                            <!-- <th>Sensor ID</th> sensor id still not connected-->
                            <th>Date</th>
                            <th>Time</th>
                            <th>Indoor Temperature</th>
                            <th>Outdoor Temperature</th>
                            <th>Particulate Matter 10</th>
                            <th>Particulate Matter 2.5</th>
                            <th>Particulate Matter 0.1</th>
                            <th>Carbon Dioxide Level</th>
                            <th>Humidity Level</th>
                        </tr>
                    </thead>
                    <tbody id = "table-body">
                        <?php include 'air_technician_parameter_table.php'; ?>
                    </tbody>
                </table>
                <div id="addroom-popup" class = "popup">
                        <span class = "add-title"> 
                            AQ Sensor Panel
                        </span>
                        <div class = "popup-line">
                        </div>
                        <form id="add-room" method="POST" class="user-input" action="housekeep_fetch_input.php">
                        
                        <label for="building_floor">Building Floor:</label>
                        <input type="number" id="building-floor" name="building-floor" required><br>

                        <label for="room-number">Room Number:</label>
                        <input type="text" id="room-number" name="room-number" required><br>
                    
                        <label for="room-name">Sensor Type:</label>
                        <input type="text" id="room-name" name="room-name" required><br>

                        <label for="room-type">Sensor Name:</label>
                        <input type="text" id="room-type" name="room-type" required><br>

                        <button class="save-details" type="submit">Add Room</button>
                        </form>
                </div>
                <table class = "air-quality-sensors-table">
                    <thead>
                        <tr>
                            <th class = "delete-column"></th>
                            <th>Room Number</th>
                            <th>Sensor ID</th>
                            <th>Sensor Type</th>
                            <th>Date Added</th>
                            <th>Status</th>
                            <th>Date of Update</th>
                        </tr>
                    </thead>
                    <tbody id = "table-body">
                        <!-- <?php include 'air_technician_parameter_table.php'; ?> -->
                    </tbody>
                </table> 
            </div>
        </div>
    </div>
    <script src="../Air Quality Technician/air_technician.js"></script>
    </body>
</html>