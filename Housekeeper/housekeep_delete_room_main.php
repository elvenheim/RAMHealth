<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RAM Health</title>
    <link rel="stylesheet" href="housekeeper.css">
    <link rel="stylesheet" href="housekeep_content_two.css">
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
        <ul id="btn_logout" class="log-out">
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
                        <div class="table-button">
                            <button class="refresh-table" onclick="location.reload()"><span class="fas fa-arrows-rotate"></span> Refresh</button>
                        </div>
                        <table class="housekeeper-table">
                            <thead>
                                <tr>
                                <th>Building Floor</th>
                                <th>Room Number</th>
                                <th>Room Type</th>
                                <th>Room Name</th>
                                <th>Created At</th>
                                <th>Deleted At</th>
                                <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="table-body">
                                <?php include 'deleted_room_table.php'; ?>
                            </tbody>
                        </table>
                        <?php include 'deleted_room_table_pagination.php'; ?>
                    </div>
                </div>
            </div>
    </body>
</html>