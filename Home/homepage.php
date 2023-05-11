<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RAM Health</title>   
    <link rel="stylesheet" href="homepage.css">
    <link rel="shortcut icon" href="../favicons/favicon.ico"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.3.0/css/all.css">
    <script src="../Home/homepage.js"></script>
</head>
    <body class="homepage-main">
        <nav class="navbar">
            <div class="apc-logo">
                <img src="https://signin.apc.edu.ph/images/logo.png" 
                alt="APC Logo" class="apc-logo-home" onclick="location.href='../Home/homepage.php';">
                <div class="ram-health-title">
                RAM Health
                </div>
            </div>
            <span id="user_full_name" name="full_name" class="log-out-name fas fa-power-off" 
                onselectstart="return false;" onclick="collapse_logout()">
                <?php include 'employee_name.php';?>
            </span>
            <span id="user_role_type" name="role_type" class="role-type" onselectstart="return false;">
                <?php include 'employee_role.php';?>
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
        <div class="content-one">
            <div class="card">
                <a class = "card-title">
                    <span>
                         Users & Accessibility
                    </span>
                </a>
        </div>
    </div>
    </body>
</html>