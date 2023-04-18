<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Administrator</title>
    <link rel="stylesheet" href="admin.css">
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
                    <?php include 'admin_name.php';?>
                </span>
                <span id="user_role_type" name="role_type" class="role-type" onselectstart="return false;">
                    <?php include 'admin_role.php';?>
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
        <!-- Admin Table -->
        <div class="content">
            <div class="card">
                <a class = "card-title">
                    <span>
                         Users & Accessibility
                    </span>
                </a>
                <div id="adduser-popup" class = "popup">
                    <span class = "add-title"> 
                        Add User
                    </span>
                    <span class = "close-popup"> 
                        <i id="close-btn"class= "fas fa-x fa-xl close-btn"></i>
                    </span>
                    <div class = "popup-line">
                    </div>
                    <form id="add_user" method="POST" class="user-input" action="admin_fetch_input.php">
                    <label for="user_id">User ID:</label>
                    <input type="text" id="user_id" name="user_id" required><br>

                    <?php include 'input_role.php'?>

                    <label for="user_fullname">Full Name:</label>
                    <input type="text" id="user_fullname" name="user_fullname" required><br>

                    <label for="user_email">Email Address:</label>
                    <input type="email" id="user_email" name="user_email" required><br>

                    <label for="user_password">Password:</label>
                    <input type="password" id="user_password" name="user_password" required><br>

                    <button class="save-details" type="submit">Save User Data</button>
                    </form>
                </div>
                <div id="adduser-popup-bg" class = "popup-bg">
                </div>  
                <div class = "table-button">
                    <button id="adduser-btn" class="add-user" onclick="adduser_popup()">
                        <span class="fas fa-plus"></span>
                        Add User
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
                <table class = "admin-table">
                    <thead>
                        <tr>
                            <th class = "delete-column"></th>
                            <th>User ID</th>
                            <th>Role</th>
                            <th>Full Name</th>
                            <th>Email Address</th>
                            <th>Creation Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id = "table-body">
                        <?php include 'admin_table.php'; ?>
                    </tbody>
                </table> 
            </div>
        </div>
    </div>
    <script src="../Administrator/admin.js"></script>
    </body>
</html>