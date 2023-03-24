function show(){
    var password = document.getElementById('password');
    var icon = document.querySelector('.fa-eye');
    if (password.type === "password") {
    password.type = "text";
    password.style.marginTop = "20px"; 
    icon.style.color = "#293A82";
    }   else{
        password.type = "password";
        icon.style.color = "#343A40";
    }
}

function housekeeper(){
        document.location.href="../Housekeeper/housekeeper.html";
}