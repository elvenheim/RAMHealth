<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Housekeeper</title>
    <link rel="stylesheet" href="housekeeper.css">
    <link rel="shortcut icon" href="https://signin.apc.edu.ph/favicons/favicon.ico"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.3.0/css/all.css">
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
                <form name="logout-form" method="post" action="../Login/new_login.html">
                    <button class="logout-button " type="submit" onclick="logout()">
                        <span class="fas fa-power-off"></span>
                        Logout
                    </button>
                </form>
            </ul>
        </nav>
    </div>
    <!-- For the Main Interface Contents -->
    <!-- Admin Table -->
    <div class="content">
        <div class="card">
            <nav class="card-header">
                <a class = "card-title">
                    <span>
                        Building Management
                    </span>
                </a>
            </nav>
                <table class = "housekeeper-table">
                    <thead>
                        <tr>
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
            </div>
        </div>
    </div>
    <script src="../Housekeeper/housekeeper.js"></script>
</body>
</html>