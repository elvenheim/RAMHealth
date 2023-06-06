<?php require_once('admin_connect.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RAM Health</title>   
    <link rel="stylesheet" href="../Administrator/Admin Design/admin.css">
    <link rel="stylesheet" href="../Administrator/Admin Design/admin_content_two.css">
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
                <nav id="user-list-table-header" class="card-header-indicator"></nav>
                    <a href="../Administrator/admin.php" class = "card-title">
                        <span> Users & Accessibility </span>
                    </a>
                <nav id="deleted-user-header" class="card-header-indicator-second"></nav>
                <a href="../Administrator/admin_deleted_user_main.php" class = "card-title-second"> 
                    <span> Deleted Users </span>
                </a>
            </nav>
            <div id="deleted-user-table" class="content-two">
                <div class="card">
                    <div class="table-button">
                        <button class="refresh-table" onclick="location.reload()"><span class="fas fa-arrows-rotate"></span> Refresh</button>                    
                    </div>
                        <table class="admin-deleted-user-table">
                            <thead>
                                <tr>
                                <th><a href="#arrange-employee_id" onclick="sortDeleteTable(0)">Employee ID<span class="sort-indicator">&#x25BC</span></a></th>
                                <th><a href="#arrange-employee_fullname" onclick="sortDeleteTable(1)">Full Name<span class="sort-indicator">&#x25BC</span></a></th>
                                <th><a href="#arrange-employee_email" onclick="sortDeleteTable(2)">Email Address<span class="sort-indicator">&#x25BC</span></a></th>
                                <th><a href="#arrange-role_names" onclick="sortDeleteTable(3)">Role<span class="sort-indicator">&#x25BC</span></a></th>
                                <th><a href="#arrange-employee_create_at" onclick="sortDeleteTable(4)">Created At<span class="sort-indicator">&#x25BC</span></a></th>
                                <th><a href="#arrange-employee_delete_at" onclick="sortDeleteTable(5)">Delete At<span class="sort-indicator">&#x25BC</span></a></th>
                                <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="deleted-user-table-body">
                                <?php include 'admin_deleted_user_table.php'; ?>
                            </tbody>
                        </table>
                            <?php include 'admin_deleted_user_pagination.php'; ?>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>