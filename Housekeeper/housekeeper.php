<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Housekeeper</title>
    <link rel="stylesheet" href="housekeeper.css">
    <link rel="shortcut icon" href="../favicons/favicon.ico"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.3.0/css/all.css">
    <script src="../Housekeeper/housekeeper.js"></script>
</head>
<body class="housekeeper-main">
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
                <?php include 'housekeep_name.php';?>
            </span>
            <span id="user_role_type" name="role_type" class="role-type" onselectstart="return false;">
                <?php include 'housekeep_role.php';?>
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
    <!-- Housekeeper Table -->
    <div class="content">
        <div class="card">
                <a class = "card-title"> Building Management </a>
                <div id="addroom-popup" class = "popup">
                        <span class = "add-title"> 
                            Building Management
                        </span>
                        <div class = "popup-line">
                        </div>
                        <form id="add_room" method="POST" class="user-input" action="housekeep_fetch_input.php">
                        
                        <label for="room_number">Room Number:</label>
                        <input type="text" id="room_number" name="room_number" required><br>
                        
                        <label for="building_floor">Building Floor:</label>
                        <input type="number" id="building_floor" name="building_floor" required><br>

                        <label for="room_name">Room Name:</label>
                        <input type="text" id="room_name" name="room_name" required><br>

                        <label for="room_type">Room Type:</label>
                        <input type="text" id="room_type" name="room_type" required><br>

                        <button class="save-details" type="submit">Add Room</button>
                        </form>
                </div>
                <div class = "table-button">
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
                <table class = "housekeeper-table">
                    <thead>
                        <tr>
                            <th class = "delete-column"></th>
                            <th>Building Floor</th>
                            <th>Room Number</th>
                            <th>Room Name</th>
                            <th>Room Type</th>
                            <th>Creation Date</th>
                        </tr>
                    </thead>
                    <tbody id = "table-body">
                        <?php include 'housekeeper_table.php'; ?>
                    </tbody>
                </table> 
                <?php include 'housekeep_pagination.php'; ?>
            </div>
        </div>
    </div>
</body>
</html>