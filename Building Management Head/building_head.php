<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RAM Health</title>
    <link rel="stylesheet" href="building_head.css">
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
                <span id="log_out_dropdown" name="log_out_dropdown" class="log-out-symbol fas fa-power-off" 
                onselectstart="return false;" onclick="collapse_logout()">
                </span>
                </div>
            </nav>
        </div>
        <ul id="btn_logout" class="log-out">
            <form id="logout" name="logout-form" method="post" action="../Login/session_logout.php">
                <button class="logout-button" type="submit" name="logout">
                    <span class="fas fa-power-off"></span>
                    Logout
                </button>
            </form>
        </ul>
        <!-- For the Main Interface Contents -->
        <!-- Building Head Table -->
        <div class="content">
            <div class="card">
                <!-- <nav class="card-header">
                </nav> -->
                <a class = "card-title">
                    <span>
                         Users & Accessibility
                    </span>
                </a>
                <div class = "table-button">
                    <button class="add-user" type="submit">
                        <span class="fas fa-plus"></span>
                        Add User
                    </button>
                    <button class="refresh-table" type="submit">
                        <span class="fas fa-arrows-rotate"></span>
                        Refresh
                    </button>
                    <button class="edit-table" type="submit">
                        <span class="fas fa-pen-to-square"></span>
                        Edit Table
                    </button>
                </div>
                <table class = "admin-table">
                    <thead>
                        <tr>
                            <th>User ID</th>
                            <th>Role</th>
                            <th>Full Name</th>
                            <th>Email Address</th>
                            <th>Creation Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id = "table-body">
                        <!-- <?php include 'admin_table.php'; ?> -->
                    </tbody>
                </table> 
            </div>
        </div>
    </div>
    <script src="../Energy Consumption Technician/energy_technician.js"></script>
    </body>
</html>