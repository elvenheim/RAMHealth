function collapse_logout(){
    var user_name = document.getElementById("user_full_name");
    if (logout.style.display !== "block"){
        logout.style.display = "none";
    } else{
        logout.style.display = "block";
    }
}

function show_Logout(){
    var logout = document.getElementById("btn_logout");
    if (logout.style.display !== "block"){
        logout.style.display = "none";
    } else{
        logout.style.display = "block";
    }
}

//function for show or hide a column
function toggleColumn() {
    var th = document.querySelectorAll('th:nth-child(2)');
    var td = document.querySelectorAll('td:nth-child(2)');
    
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
}