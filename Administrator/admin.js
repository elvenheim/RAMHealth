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
    alert("You have been logged out!");
}