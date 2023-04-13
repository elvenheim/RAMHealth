<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Housekeeper</title>
    <link rel="stylesheet" href="housekeeper.css">
    <link rel="shortcut icon" href="https://signin.apc.edu.ph/favicons/favicon.ico"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.3.0/css/all.css">
</head>
<body class="house-keeper-main">
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand navbar-gray">
            <ul class="navbar-nav ml-auto">
                <!-- FOR LOG OUT -->
                <li class="nav-item dropdown user-menu">
                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                        <span>
                            RICH DIAMOND POLANCOS CUSTODIO
                        </span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0 px;">
                        <form name="logout-form" method="post" action="../Login/new_login.html">
                            <button class="signin-button button" type="submit">
                                <span class="fas fa-sign-in-alt"></span>
                                Logout
                             </button>
                        </form>
                    </ul>
                    
                </li>
            </ul>
        </nav>
    </div>
    <div class="interface-wrapper">
        <h1>This is the Housekeper Page</h1>
    </div>
</body>
</html>