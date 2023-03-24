function show(){
          var pswrd = document.getElementById('pswrd');
          var icon = document.querySelector('.fa-eye');
          if (pswrd.type === "password") {
           pswrd.type = "text";
           pswrd.style.marginTop = "20px";
           icon.style.color = "#293A82";
          }else{
           pswrd.type = "password";
           icon.style.color = "#343A40";
          }
}

function housekeeper(){
            location.href="./Housekeeper/housekeeper.html";
}