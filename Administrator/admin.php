<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RAM Health</title>   
    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="admin_header.css">
    <link rel="stylesheet" href="admin_content.css">
    <link rel="stylesheet" href="admin_content_two.css">
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
                    <a class = "card-title" onclick="navUserTable()">
                        <span> Users & Accessibility </span>
                    </a>
                <nav id="deleted-user-header" class="card-header-indicator-second"></nav>
                <a class = "card-title-second" onclick="navDeletedUserTable()"> 
                    <span> Deleted Users </span>
                </a>
            </nav>
            <div id="user-list-table"class="content-one">
                <div class="card">
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
                        <button class="edit-table" onclick="location.reload()">
                            <span class="fas fa-pen-to-square"></span>
                            Edit
                        </button>
                    </div>
                    <table class="admin-table">
                        <thead>
                            <tr>
                            <th>Employee ID</th>
                            <th>Full Name</th>
                            <th>Email Address</th>
                            <th>Role</th>
                            <th>Created At</th>
                            <th>Account Status</th>
                            <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="table-body">
                            <?php include 'admin_table.php'; ?>
                        </tbody>
                    </table>
                    <?php include 'admin_pagination.php'; ?>
                </div>
            </div>
            <div id="deleted-user-table" class="content-two">
            <div class="card">
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
                        <button class="edit-table" onclick="location.reload()">
                            <span class="fas fa-pen-to-square"></span>
                            Edit
                        </button>
                    </div>
                    <table class="admin-deleted-user-table">
                        <thead>
                            <tr>
                            <th>Employee ID</th>
                            <th>Full Name</th>
                            <th>Email Address</th>
                            <th>Role</th>
                            <th>Created At</th>
                            <th>Account Status</th>
                            <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="table-body">
                            <?php include 'admin_table.php'; ?>
                        </tbody>
                    </table>
                    <?php include 'admin_pagination.php'; ?>
                </div>
            </div>
            </div>
        </div>
    </body>
</html>