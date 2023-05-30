<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RAM Health</title>
    <link rel="stylesheet" href="housekeeper.css">
    <link rel="stylesheet" href="housekeep_content_one.css">
    <link rel="shortcut icon" href="../favicons/favicon.ico"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.3.0/css/all.css">
    <script src="../Housekeeper/housekeeper.js"></script>
</head>
    <body class="housekeeper-main">
        <nav class="navbar">
            <div class="ram-health-logo">
                <div class="ram-health-title" onclick="location.href='../Home/homepage.php';">
                RAM Health
                </div>
            </div>
            <span id="log_out_dropdown" name="log_out_dropdown" class="log-out-symbol fas fa-power-off" 
                onselectstart="return false;" onclick="collapse_logout()">
            </span>
            </div>
            </nav>
        <ul id="btn_logout" class="log-out" style="display: none;">
            <form id="logout" name="logout-form" method="post" action="../Login/session_logout.php">
                <button class="logout-button" type="submit" name="logout">
                    <span class="fas fa-power-off"></span>
                    Logout
                </button>
            </form>
        </ul>
        <div class="content">
                <nav class="card-header">
                    <nav id="room-list-table-header" class="card-header-indicator"></nav>
                        <a href="../Housekeeper/housekeeper.php" class = "card-title">
                            <span> Room Management </span>
                        </a>
                    <nav id="deleted-room-header" class="card-header-indicator-second"></nav>
                    <a href="../Housekeeper/housekeep_delete_room_main.php" class = "card-title-second"> 
                        <span> Deleted Rooms </span>
                    </a>
                </nav>
                <div id="user-list-table"class="content-one">
                    <div class="card">
                        <!-- add room pop-up -->
                        <div id="addroom-popup" class = "popup" style="opacity: 0; pointer-events: none;">
                            <span class = "add-title"> 
                                Add Room
                            </span>
                            <span class = "close-popup"> 
                                <i id="add-close-btn"class= "fas fa-x fa-xl close-btn"></i>
                            </span>
                            <div class = "popup-line">
                            </div>

                            <form id="add_room" method="POST" class="user-input" action="housekeep_fetch_input.php">
                            <label for="room_number">Room Number:</label>
                            <input type="text" id="room_number" name="room_number"required><br>
                            
                            <?php include 'input_floor.php'; ?>

                            <label for="room_type">Room Type:</label>
                            <input type="text" id="room_type" name="room_type" required><br>

                            <label for="room_name">Room Name:</label>
                            <input type="text" id="room_name" name="room_name" required><br>

                            <button class="save-details" type="submit">Add Room Data</button>
                            </form>
                        </div>

                        <div id="addroom-popup-bg" class = "popup-bg" style="opacity: 0; pointer-events: none;">
                        </div>

                        <div class="table-button">
                            <button id="adduser-btn" class="add-room" onclick="addroom_popup()"><span class="fas fa-plus"></span> Add Room</button>
                            <button class="refresh-table" onclick="location.reload()"><span class="fas fa-arrows-rotate"></span> Refresh</button>
                        </div>
                        <table class="housekeeper-table">
                            <thead>
                                <tr>
                                <th>Building Floor</th>
                                <th>Room Number</th>
                                <th>Room Type</th>
                                <th>Room Name</th>
                                <th>Updated At</th>
                                <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="table-body">
                                <?php include 'housekeeper_table.php'; ?>
                            </tbody>
                        </table>
                        <?php include 'housekeep_pagination.php'; ?>
                    </div>
                </div>
            </div>
    </body>
</html>