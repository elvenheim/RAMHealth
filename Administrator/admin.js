src="https://code.jquery.com/jquery-3.6.0.min.js"

function collapse_logout(){
  var fullName = document.getElementById("logout")
  var logoutBtn = document.getElementById("btn_logout");

  if (logoutBtn.style.display === "none") {
    logoutBtn.style.display = "block";
    fullName.style.color = "#E7AE41"
  } else {
    logoutBtn.style.display = "none";
    fullName.style.color ="#FFF"
  }
}

function adduser_popup() {
  console.log("adduser_popup function called");
  var popup = document.getElementById("adduser-popup");
  var popupBg = document.getElementById("adduser-popup-bg");
  var popup_close_btn = document.getElementById("close-btn");

  if (popupBg.style.opacity === "0" && popup.style.opacity === "0") {
    popupBg.style.opacity = "1";
    popup.style.opacity = "1";
    popupBg.style.pointerEvents = "visible";
    popup.style.pointerEvents = "visible";
    popup_close_btn.style.cursor = "pointer";
  } else {
    popupBg.style.opacity = "0";
    popup.style.opacity = "0";
    popupBg.style.pointerEvents = "none";
    popup.style.pointerEvents = "none";
    popup_close_btn.style.cursor = "default";
    document.getElementById("add_user").reset();
  }
  popup_close_btn.setAttribute("onclick", "adduser_popup()");
}