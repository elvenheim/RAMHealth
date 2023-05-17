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
  popup_close_btn.setAttribute("onclick", "addroom_popup()");
}

function editRow(roomId) {
  console.log("addroom_popup function called");
  var popup = document.getElementById("addroom-popup");
  var popupBg = document.getElementById("addroom-popup-bg");
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
  popup_close_btn.setAttribute("onclick", "addroom_popup()");
}

function deleteRow(roomNum) {
  if (confirm("Are you sure you want to delete this room?")) {
      var xhr = new XMLHttpRequest();
      xhr.open("POST", "housekeep_delete_room_table.php", true);
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      xhr.onreadystatechange = function() {
          if (xhr.readyState == 4 && xhr.status == 200) {
              alert("Room has been successfully deleted.");
              window.location.href = "housekeeper.php";
          }
      };
      xhr.send("room_num=" + roomNum);
  }
}

function restoreRow(roomNum) {
  if (confirm("Are you sure you want to restore this room?")) {
      var xhr = new XMLHttpRequest();
      xhr.open("POST", "housekeep_restore_room.php", true);
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      xhr.onreadystatechange = function() {
          if (xhr.readyState == 4 && xhr.status == 200) {
              alert("Room has been successfully restored.");
              window.location.href = "housekeep_delete_room_main.php";
          }
      };
      xhr.send("room_num=" + roomNum);
  }
}