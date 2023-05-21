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

// prevent back button of browser
(function () {
    if (window.history && window.history.pushState) {
        window.history.pushState('', null, './homepage.php');
        window.onpopstate = function () {
            window.history.pushState('', null, './homepage.php');
        };
    }
})();
