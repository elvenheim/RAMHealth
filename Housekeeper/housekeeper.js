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

function sortTable(columnIndex) {
  let table, rows, switching, i, x, y, shouldSwitch, sortIndicator;
  table = document.querySelector(".housekeeper-table");
  switching = true;
  sortIndicator = document.querySelector(
      `th:nth-child(${columnIndex + 1}) .sort-indicator`
  );

  let sortOrder = sortIndicator.getAttribute("data-sort-order") || "asc";
  
  while (switching) {
      switching = false;
      rows = table.rows;
      
      for (i = 1; i < rows.length - 1; i++) {
          shouldSwitch = false;
          x = rows[i].getElementsByTagName("td")[columnIndex];
          y = rows[i + 1].getElementsByTagName("td")[columnIndex];

          let xValue = x.innerHTML.toLowerCase();
          let yValue = y.innerHTML.toLowerCase();
          
          if (sortOrder === "asc") {
              if (xValue > yValue) {
                  shouldSwitch = true;
                  break;
              }
          } else {
              if (xValue < yValue) {
                  shouldSwitch = true;
                  break;
              }
          }
      }
      
      if (shouldSwitch) {
          rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
          switching = true;
      }
  }
  
  // Toggle the sorting order
  if (sortOrder === "asc") {
      sortIndicator.setAttribute("data-sort-order", "desc");
      sortIndicator.innerHTML = "&#x25BC;";
  } else {
      sortIndicator.setAttribute("data-sort-order", "asc");
      sortIndicator.innerHTML = "&#x25B2;";
  }
}

function sortDeleteTable(columnIndex) {
  let table, rows, switching, i, x, y, shouldSwitch, sortIndicator;
  table = document.querySelector(".deleted-housekeeper-table");
  switching = true;
  sortIndicator = document.querySelector(
      `th:nth-child(${columnIndex + 1}) .sort-indicator`
  );

  let sortOrder = sortIndicator.getAttribute("data-sort-order") || "asc";
  
  while (switching) {
      switching = false;
      rows = table.rows;
      
      for (i = 1; i < rows.length - 1; i++) {
          shouldSwitch = false;
          x = rows[i].getElementsByTagName("td")[columnIndex];
          y = rows[i + 1].getElementsByTagName("td")[columnIndex];

          let xValue = x.innerHTML.toLowerCase();
          let yValue = y.innerHTML.toLowerCase();
          
          if (sortOrder === "asc") {
              if (xValue > yValue) {
                  shouldSwitch = true;
                  break;
              }
          } else {
              if (xValue < yValue) {
                  shouldSwitch = true;
                  break;
              }
          }
      }
      
      if (shouldSwitch) {
          rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
          switching = true;
      }
  }
  
  // Toggle the sorting order
  if (sortOrder === "asc") {
      sortIndicator.setAttribute("data-sort-order", "desc");
      sortIndicator.innerHTML = "&#x25BC;";
  } else {
      sortIndicator.setAttribute("data-sort-order", "asc");
      sortIndicator.innerHTML = "&#x25B2;";
  }
}