function show_password(){
    var password = document.getElementById('password');
    var icon = document.querySelector('.fa-eye');
    if (password.type === "password") {
    password.type = "text";
    password.style.marginTop = "20px"; 
    icon.style.color = "#E7AE41";
    }   else{
        password.type = "password";
        icon.style.color = "#343A40";
    }
}

// Sample Functions for the submit or login button (will replace later)

function housekeeper(){
    document.location.href="../Housekeeper/housekeeper.html";
}

function air_technician(){
    document.location.href="../Air Quality Technician/air_technician.html"
}

function energy_technician(){
    document.location.href="../Energy Consumption Technician/energy_technician.html"
}

function admin(){
    document.location.href="../Administrator/admin.html"
}

function building_head(){
    document.location.href="../Building Management Head/building_head.html"
}