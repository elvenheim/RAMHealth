<?php require_once('admin_connect.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RAM Health</title>   
    <link rel="stylesheet" href="../Administrator/Admin Design/admin.css">
    <link rel="stylesheet" href="../Administrator/Admin Design/admin_content_one.css">
    <link rel="shortcut icon" href="../favicons/favicon.ico"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.3.0/css/all.css">
    <script src="../Administrator/admin.js"></script>
</head>
    <body class="admin-main">
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
        <!-- Admin Table -->
        <div class="content">
            <nav class="card-header">
                <nav id="user-list-table-header" class="card-header-indicator"></nav>
                    <a href="../Administrator/admin.php" class = "card-title">
                        <span> Users & Accessibility </span>
                    </a>
                <nav id="deleted-user-header" class="card-header-indicator-second"></nav>
                <a href="../Administrator/admin_deleted_user_main.php" class = "card-title-second"> 
                    <span> Deleted Users </span>
                </a>
            </nav>
            <div id="user-list-table" class="content-one">
                <div class="card">
                    <div id="adduser-popup" class = "popup" style="opacity: 0; pointer-events: none;">
                        <span class = "add-title"> 
                            Add User
                        </span>
                        <span class = "close-popup"> 
                            <i id="close-btn" class= "fas fa-x fa-xl close-btn"></i>
                        </span>
                        <div class = "popup-line">
                        </div>
                        <form id="add_user" method="POST" class="user-input" action="admin_fetch_input.php">
                        <label for="employee_id">Employee ID:</label>
                        <input type="number" id="employee_id" name="employee_id"required><br>

                        <?php include 'input_role.php'?>
                        
                        <label for="employee_fullname">Full Name:</label>
                        <input type="text" id="employee_fullname" name="employee_fullname" required><br>

                        <label for="employee_email">Email Address:</label>
                        <input type="email" id="employee_email" name="employee_email" required><br>

                        <label for="employee_password">Password:</label>
                        <input type="password" id="employee_password" name="employee_password" required><br>

                        <button class="save-details" type="submit">Save User Data</button>
                        </form>
                    </div>
                    <div id="adduser-popup-bg" class = "popup-bg" style="opacity: 0; pointer-events: none;">
                    </div>  
                    <div class="table-button">
                        <button id="adduser-btn" class="add-user" onclick="adduser_popup()"><span class="fas fa-plus"></span> Add User</button>
                        <button class="refresh-table" onclick="location.reload()"><span class="fas fa-arrows-rotate"></span> Refresh</button>                    
                    </div>
                        <table class="admin-table">
                        <thead>
                            <tr>
                            <th><a href="#arrange-employee_id" onclick="sortTable(0)">User ID<span class="sort-indicator">&#x25BC</span></a></th>
                            <th><a href="#arrange-employee_fullname" onclick="sortTable(1)">Full Name<span class="sort-indicator">&#x25BC</span></a></th>
                            <th><a href="#arrange-employee_email" onclick="sortTable(2)">Email Address<span class="sort-indicator">&#x25BC</span></a></th>
                            <th><a href="#arrange-role_names" onclick="sortTable(3)">Role<span class="sort-indicator">&#x25BC</span></a></th>
                            <th><a href="#arrange-employee_create_at" onclick="sortTable(4)">Created At<span class="sort-indicator">&#x25BC</span></a></th>
                            <th>Account Status</th>
                            <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="table-body">
                            <?php include 'admin_table.php'; ?>
                        </tbody>
                        </table>
                    <?php include 'admin_user_table_pagination.php'; ?>
                </div>
            </div>
        </div>
    </body>
</html>