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
}