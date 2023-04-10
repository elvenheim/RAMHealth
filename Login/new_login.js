function show_password(){
    var password = document.getElementById('password_field');
    var icon = document.querySelector('.fa-eye');
    if (password.type === "password") {
    password.type = "text";
    password.style.marginTop = "20px"; 
    icon.style.color = "#E7AE41";
    }   else{
        password.type = "password";
        icon.style.color = "#343A40";
    }
};