<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Administrator</title>
    <link rel="stylesheet" href="admin.css">
    <link rel="shortcut icon" href="https://signin.apc.edu.ph/favicons/favicon.ico"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.3.0/css/all.css">
</head>
    <!-- this is for custom alert on logout -->
    <!-- <div id="myAlert" class="alert">
        <span class="closebtn" onclick="closeAlert()">&times;</span>
        <strong>Alert:</strong> 
        This is a custom alert message.
    </div> -->
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
                            Users & Accessibility
                        </span>
                    </a>
                </nav>
                    <table class = "admin-table">
                        <thead>
                            <tr>
                                <th>User ID</th>
                                <th>Role ID</th>
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