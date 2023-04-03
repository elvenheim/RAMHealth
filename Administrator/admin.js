function collapse_logout(){
    var user_name = document.getElementById("user_full_name");
    if (logout.style.display !== "block"){
        logout.style.display = "none";
    } else{
        logout.style.display = "block";
    }
};

function show_Logout(){
    var logout = document.getElementById("btn_logout");
    if (logout.style.display !== "block"){
        logout.style.display = "none";
    } else{
        logout.style.display = "block";
    }
};