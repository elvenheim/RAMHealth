function collapse_logout(){
    var fullName = document.getElementById("user_full_name")
    var logoutBtn = document.getElementById("btn_logout");

    if (logoutBtn.style.display === "none") {
      logoutBtn.style.display = "block";
      fullName.style.color = "#E7AE41"
    } else {
      logoutBtn.style.display = "none";
      fullName.style.color ="#FFF"
    }
}

function logout(){
    if (confirm("Are you sure you want to log out?")) {
      window.location.href = "../Login/new_login.html";
    }
}