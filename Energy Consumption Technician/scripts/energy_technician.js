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

function cancelEdit() {
  window.location.href = 'energy_technician_sensor_main.php'; // Replace with the desired page URL to redirect the user
}

function toggleDropdown() {
  var menu = document.getElementById('sensor-menu');
  menu.classList.toggle('show');
}

function selectAll(source) {
  var checkboxes = document.getElementsByName('ec_sensor[]');
  for (var i = 0; i < checkboxes.length; i++) {
      checkboxes[i].checked = source.checked;
  }
}

function updatePanelLabelDropdown(selectedPanelGroup) {
  var xhr = new XMLHttpRequest();
  xhr.open('POST', '../Energy Consumption Technician/filter_panel_label.php', true);
  xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
  xhr.onreadystatechange = function() {
    if (xhr.readyState === 4 && xhr.status === 200) {
      var dropdownFormTwo = document.querySelector('.dropdown-form-two');
      dropdownFormTwo.innerHTML = xhr.responseText;

      var selectElement = dropdownFormTwo.querySelector('.panel_label');
      selectElement.value = '';
    }
  };
  xhr.send('selected_panel_group=' + encodeURIComponent(selectedPanelGroup));
}

function updateArduinoLabelDropdown(selectedPanelLabel) {
  var xhr = new XMLHttpRequest();
  xhr.open('POST', '../Energy Consumption Technician/filter_arduino_label.php', true);
  xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
  xhr.onreadystatechange = function() {
    if (xhr.readyState === 4 && xhr.status === 200) {
      var dropdownFormThree = document.querySelector('.dropdown-form-three');
      dropdownFormThree.innerHTML = xhr.responseText;

      var selectElement = dropdownFormThree.querySelector('.arduino_label');
      selectElement.value = '';
    }
  };
  xhr.send('selected_panel_label=' + encodeURIComponent(selectedPanelLabel));
}

function updateSensorDropdown(selectedArduino) {
  var container = document.getElementById('dropdown-sensor');
  container.innerHTML = '<p>Loading rooms...</p>';
  
  var xhr = new XMLHttpRequest();
  xhr.open('POST', '../Energy Consumption Technician/filter_sensor_checkbox.php', true);
  xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
  xhr.onreadystatechange = function() {
      if (xhr.readyState === 4 && xhr.status === 200) {
          var dropdownSensor = document.querySelector('.dropdown-sensor');
          dropdownSensor.innerHTML = xhr.responseText;
    
          // var selectElement = dropdownFormThree.querySelector('.arduino_label');
          // selectElement.value = '';
      }
  };
  xhr.send('selected_arduino=' + encodeURIComponent(selectedArduino));
}