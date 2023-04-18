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
      window.location.href = "../Login/new_login.php";
    }
}

function adduser_popup(){
  var popup = document.getElementById("adduser-popup");
  var popupBg = document.getElementById("adduser-popup-bg");
  var popup_close_btn = document.getElementById("close-btn");

  if (popupBg.style.opacity === "0" && popup.style.opacity === "0") {
    popupBg.style.opacity = "1";
    popup.style.opacity = "1";
    popupBg.style.pointerEvents = "visible";
    popup.style.pointerEvents = "visible";
    popup_close_btn.style.cursor = "pointer";
    popup_close_btn.setAttribute("onclick", "adduser_popup()");
  } else {
    popupBg.style.opacity = "0";
    popup.style.opacity = "0";
    popupBg.style.pointerEvents = "none";
    popupBg.style.pointerEvents = "none";
    popup_close_btn.style.cursor = "default";
    popup_close_btn.removeAttribute("onclick");
    document.getElementById("add_user").reset();
  }
}

