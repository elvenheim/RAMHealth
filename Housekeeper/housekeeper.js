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

function addroom_popup() {
  console.log("addroom_popup function called");
  var popup = document.getElementById("addroom-popup");
  var popupBg = document.getElementById("addroom-popup-bg");
  var popup_close_btn = document.getElementById("add-close-btn");

  if (popupBg.style.opacity === "0" && popup.style.opacity === "0") {
    popupBg.style.opacity = "1";
    popup.style.opacity = "1";
    popupBg.style.pointerEvents = "visible";
    popup.style.pointerEvents = "visible";
    popup_close_btn.style.cursor = "pointer";
    popup_close_btn.style.pointerEvents = "visible";
  } else {
    popupBg.style.opacity = "0";
    popup.style.opacity = "0";
    popupBg.style.pointerEvents = "none";
    popup.style.pointerEvents = "none";
    popup_close_btn.style.cursor = "default";
    popup_close_btn.style.pointerEvents = "none";
    document.getElementById("add_room").reset();
  }
  popup_close_btn.setAttribute("onclick", "addroom_popup()");
}