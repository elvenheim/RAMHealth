<?php require_once('air_technician_connect.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RAM Health</title>
    <link rel="stylesheet" href="../Air Quality Technician/AQ Tech Design/air_technician.css">
    <link rel="stylesheet" href="../Air Quality Technician/AQ Tech Design/Sensors/aq_content_sensors.css">
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
                    <span> Air Quality Parameter Table </span>
                </a>
                <nav id="sensor-header" class="card-header-indicator-second"></nav>
                <a href="air_technician_sensor_main.php" class = "card-title-second"> 
                    <span> Air Quality Sensors </span>
                </a>
                <nav id="deleted-sensor-header" class="card-header-indicator-third"></nav>
                <a href="air_technician_deleted_sensor_main.php" class = "card-title-third"> 
                    <span> Deleted Air Quality Sensors </span>
                </a>
            </nav>
            <div id="sensor-table" class="content-sensor">
                <div class="card">
                    <!-- add room pop-up -->
                    <div id="adduser-popup" class = "popup" style="opacity: 0; pointer-events: none;">
                        <span class = "add-title"> 
                            Add Sensor
                        </span>
                        <span class = "close-popup"> 
                            <i id="close-btn" class= "fas fa-x fa-xl close-btn"></i>
                        </span>
                        <div class = "popup-line">
                        </div>
                        <form id="add_user" method="POST" class="user-input" action="aq_sensor_fetch_input.php">
                            <label for="sensor-id">Sensor ID:</label>
                            <input type="text" id="sensor_id" name="sensor_id" required><br>
                            <label for="sensor-name">Sensor Name:</label>
                            <input type="text" id="sensor_name" name="sensor_name" required><br>
                            <?php include 'input_sensor.php'?>
                            <?php include 'input_room.php'?>
                            <button class="save-details" type="submit">Add Room</button>
                        </form>
                    </div>
                    <div id="adduser-popup-bg" class = "popup-bg" style="opacity: 0; pointer-events: none;">
                    </div>

                    <!-- edit room pop-up -->
                    <div id="editroom-popup" class = "popup" style="opacity: 0; pointer-events: none;">
                            <span class = "add-title"> 
                                Edit Room
                            </span>

                            <span class = "close-popup"> 
                                <i id="edit-close-btn"class= "fas fa-x fa-xl close-btn"></i>
                            </span>

                            <div class = "popup-line">
                            </div>

                            <form id="edit_room" method="POST" class="user-input" action="housekeep_fetch_input.php">
                            <label for="room_number">Room Number:</label>
                            <input type="text" id="room_number" name="room_number"required><br>
                            
                            <?php include 'input_floor.php'; ?>

                            <label for="room_type">Room Type:</label>
                            <input type="text" id="room_type" name="room_type" required><br>

                            <label for="room_name">Room Name:</label>
                            <input type="text" id="room_name" name="room_name" required><br>

                            <button class="save-details" type="submit">Update Room Data</button>
                            </form>
                    </div>
                    <div id="editroom-popup-bg" class = "popup-bg" style="opacity: 0; pointer-events: none;">
                    </div>  

                    <div class="table-button">
                        <button id="adduser-btn" class="add-user" onclick="adduser_popup()"><span class="fas fa-plus"></span> Add Sensor</button>
                        <button class="refresh-table" onclick="location.reload()"><span class="fas fa-arrows-rotate"></span> Refresh</button>                    
                    </div>
                    <table class = "air-quality-sensors-table">
                        <thead>
                            <tr>
                                <th>Sensor ID</th>
                                <th>Sensor Name</th>
                                <th>Sensor Type</th>
                                <th>Room Number</th>
                                <th>Date Added</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id = "table-body-sensor">
                            <?php include 'air_technician_sensor_table.php'; ?>
                        </tbody>
                    </table>
                    <?php include '../Air Quality Technician/AQ Tech Design/AQ Tech Pagination/aq_tech_sensor_pagination.php'; ?>
                </div>
                </nav>
            </div>
        </div>
    </body>
</html>