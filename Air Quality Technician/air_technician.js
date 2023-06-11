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

function submitForm() {
  document.querySelector('.import-table').submit();
}

function toggleDropdown() {
  var menu = document.getElementById('room-number-menu');
  menu.classList.toggle('show');
}

function selectAll(source) {
  var checkboxes = document.getElementsByName('room_number[]');
  for (var i = 0; i < checkboxes.length; i++) {
      checkboxes[i].checked = source.checked;
  }
}

function updateRoomsDropdown(selectedFloor) {
  var container = document.getElementById('dropdown-room');
  container.innerHTML = '<p>Loading rooms...</p>';
  
  var xhr = new XMLHttpRequest();
  xhr.open('POST', 'input_room_checkbox.php', true);
  xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
  xhr.onreadystatechange = function() {
      if (xhr.readyState === 4 && xhr.status === 200) {
          container.innerHTML = xhr.responseText;
      }
  };
  xhr.send('selected_floor=' + encodeURIComponent(selectedFloor));
}

function submitForm() {
  document.querySelector('.import-table').submit();
}

function cancelEdit() {
  window.location.href = 'air_technician_sensor_main.php'; // Replace with the desired page URL to redirect the user
}
