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

function downloadExcel() {
  // Create an XMLHTTPRequest to get the Excel file from the server
  var xhr = new XMLHttpRequest();
  xhr.open('GET', 'path/to/excel/file', true);
  xhr.responseType = 'blob';
  xhr.onload = function(e) {
      if (this.status == 200) {
          // Create a download link for the Excel file
          var blob = new Blob([this.response], {type: 'application/vnd.ms-excel'});
          var url = URL.createObjectURL(blob);
          var link = document.createElement('a');
          link.href = url;
          link.download = 'file.xlsx';
          link.click();
      }
  };
  xhr.send();
};

function navParameter(){
  var navParamHeader = document.getElementById("param-header");
  var navSensorHeader = document.getElementById("sensor-header");
  var navParamTable = document.getElementById("param-table");
  var navSensorTable = document.getElementById("sensor-table");

  if(navParamTable.style.opacity === "1") {
    navParamHeader.style.opacity = "1";
    navParamTable.style.opacity = "1";
    navParamTable.style.pointerEvents = "visible";
    navSensorHeader.style.opacity = "0";
    navSensorTable.style.opacity = "0";
    navSensorTable.style.pointerEvents = "none";
  }else{
    navParamHeader.style.opacity = "1";
    navParamTable.style.opacity = "1";
    navParamTable.style.pointerEvents = "visible";
    navSensorHeader.style.opacity = "0";
    navSensorTable.style.opacity = "0";
    navSensorTable.style.pointerEvents = "none";
  }
}

function navSensor(){
  var navParamHeader = document.getElementById("param-header");
  var navSensorHeader = document.getElementById("sensor-header");
  var navParamTable = document.getElementById("param-table");
  var navSensorTable = document.getElementById("sensor-table");

  if(navSensorTable.style.opacity === "0") {
    navSensorHeader.style.opacity = "1";
    navSensorTable.style.opacity = "1";
    navSensorTable.style.pointerEvents = "visible";

    navParamHeader.style.opacity = "0";
    navParamTable.style.opacity = "0";
    navParamTable.style.pointerEvents = "none";
  }else{
    navSensorHeader.style.opacity = "1";
    navSensorTable.style.opacity = "1";
    navSensorTable.style.pointerEvents = "visible";

    navParamHeader.style.opacity = "0";
    navParamTable.style.opacity = "0";
    navParamTable.style.pointerEvents = "none";
  }
}
