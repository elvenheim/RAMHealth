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

function navUserTable(){
  var navUserTableHeader = document.getElementById("user-list-table-header");
  var navDeletedUserHeader = document.getElementById("deleted-user-header");
  var navContentOne = document.getElementById("user-list-table");
  var navContentTwo = document.getElementById("deleted-user-table");

  if(navContentOne.style.opacity === "1") {
    navUserTableHeader.style.opacity = "1";
    navContentOne.style.opacity = "1";
    navContentOne.style.pointerEvents = "visible";
    navDeletedUserHeader.style.opacity = "0";
    navContentTwo.style.opacity = "0";
    navContentTwo.style.pointerEvents = "none";
  }else{
    navUserTableHeader.style.opacity = "1";
    navContentOne.style.opacity = "1";
    navContentOne.style.pointerEvents = "visible";
    navDeletedUserHeader.style.opacity = "0";
    navContentTwo.style.opacity = "0";
    navContentTwo.style.pointerEvents = "none";
  }
}

function navDeletedUserTable(){
  var navUserTableHeader = document.getElementById("user-list-table-header");
  var navDeletedUserHeader = document.getElementById("deleted-user-header");
  var navContentOne = document.getElementById("user-list-table");
  var navContentTwo = document.getElementById("deleted-user-table");

  if(navContentTwo.style.opacity === "0") {
    navDeletedUserHeader.style.opacity = "1";
    navContentTwo.style.opacity = "1";
    navContentTwo.style.pointerEvents = "visible";
    navUserTableHeader.style.opacity = "0";
    navContentOne.style.opacity = "0";
    navContentOne.style.pointerEvents = "none";
  }else{
    navDeletedUserHeader.style.opacity = "1";
    navContentTwo.style.opacity = "1";
    navContentTwo.style.pointerEvents = "visible";
    navUserTableHeader.style.opacity = "0";
    navContentOne.style.opacity = "0";
    navContentOne.style.pointerEvents = "none";
  }
}