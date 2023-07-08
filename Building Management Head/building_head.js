function collapse_logout(){
    var logoutBtn = document.getElementById("btn_logout");
    if (logoutBtn.style.display === "none") {
      logoutBtn.style.display = "block";
    } else {
      logoutBtn.style.display = "none";
    }
}

function logout(){
    if (confirm("Are you sure you want to log out?")) {
      window.location.href = "../Login/new_login.php";
    }
}