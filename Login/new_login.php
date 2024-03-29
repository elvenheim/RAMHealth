<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <title>RAM Health</title>
      <link rel="stylesheet" href="new_login.css">
      <link rel="shortcut icon" href="../favicons/favicon.ico"/>
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.3.0/css/all.css">
      <script src="../Login/new_login.js"></script>
   </head>
   <body class="login-page">
      <div class="center">
         <div class="header">
            <div class="d-flex justify-content-center logo">
               <img src="https://signin.apc.edu.ph/images/logo.png" width="120px"/>
            </div>
            <div class="d-flex justify-content-center login-header-title">
               <h3><b>APC RAM Health</b></h3>
            </div>
            <div class="d-flex justify-content-center">
               <h5>Login with <img id="o365logo" src="../images/office-365-logo.png" width="90"/>Account</h5>
            </div>
         </div>
         <!-- NOW CONNECTED TO DATABASE -->
         <form action="authentication.php" name="signin-form" method="POST" autocomplete="off">
            <?php
               if (isset($_GET['error'])) {
                  $error = $_GET['error'];
                  if ($error === 'disabled') {
                     echo '<p class="disabled-message">Account is disabled.<br>Please contact the administrator.</p>';
                  } elseif ($error === 'invalid_credentials') {
                     echo '<p class="invalid-message">Invalid email or password. Please try again.</p>';
                  } elseif ($error === 'invalid_email') {
                     echo '<p class="invalid-message">Invalid email or password. Please try again.</p>';
                 }
               }
            ?>
            <input id="email_field" name="email" type="email" placeholder="Email" autocomplete="email" autofocus required>
            <i class="fas fa-envelope"></i>
            <input id="password_field" name="password" type="password" placeholder="Password" autocomplete="password" required>
            <i class="fas fa-eye" onclick="show_password()"></i>
            <button type="submit" name="signin" class="signin-button button">
               <span class="fas fa-sign-in-alt"></span>
               Sign In
            </button>
         </form>
      </div>
   </body>
</html>
