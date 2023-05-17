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
            <div class="ram-health-logo">
                <div class="ram-health-title" onclick="location.href='../Home/homepage.php';">
                RAM Health
                </div>
            </div>
            <span id="user_full_name" name="full_name" class="log-out-name"
                onselectstart="return false;" onclick="collapse_logout()">
                <?php include 'employee_name.php';?>
            </span>
        </nav>
        <ul id="btn_logout" class="log-out">
            <form id="logout" name="logout-form" method="post" action="../Login/session_logout.php">
                <button class="logout-button" type="submit" name="logout">
                    <span class="fas fa-power-off"></span>
                    Logout
                </button>
            </form>
        </ul>
        <div class="home-content">
            <div class="card">
                <a class = "card-title">
                    <span>
                        Home Page
                    </span>
                </a>
                <div class="role-list-card">
                    <?php include 'role_links.php'?>
                </div>
            </div>
        </div>
    </body>
</html>