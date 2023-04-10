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

// Define the toggleColumn function
function toggle_Column() {
    var th = document.querySelectorAll('th:nth-child(5)');
    var td = document.querySelectorAll('td:nth-child(5)');
    
    if (th[0].style.display == '' || th[0].style.display == 'table-cell') {
      // Hide the column and its header
      for (var i = 0; i < th.length; i++) {
        th[i].style.display = 'none';
      }
      for (var i = 0; i < td.length; i++) {
        td[i].style.display = 'none';
      }
    } else {
      // Show the column and its header
      for (var i = 0; i < th.length; i++) {
        th[i].style.display = 'table-cell';
      }
      for (var i = 0; i < td.length; i++) {
        td[i].style.display = 'table-cell';
      }
    }
};
