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
