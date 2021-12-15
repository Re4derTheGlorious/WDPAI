function button_UPLOAD(){
    console.log("Click: UPLOAD");
    document.getElementById('fade').style.display = "initial";
    document.getElementById('upload_panel').style.display = "initial";
}
function button_USER(){
    console.log("Click: USER");
    document.getElementById('fade').style.display = "initial";
    document.getElementById('user_panel').style.display = "initial";
}
function button_INFO(){
    console.log("Click: INFO");
    document.getElementById('fade').style.display = "initial";
    document.getElementById('about_panel').style.display = "initial";
}
function button_LEFT(){
    console.log("Click: LEFT");
    cycle(-1);
}
function button_LEFT2(){
    console.log("Click: LEFT");
    cycle(-2);
}
function button_LEFT3(){
    console.log("Click: LEFT");
    cycle(-3);
}
function button_RIGHT(){
    console.log("Click: RIGHT");
    cycle(1);
}
function button_RIGHT2(){
    console.log("Click: RIGHT");
    cycle(2);
}
function button_RIGHT3(){
    console.log("Click: RIGHT");
    cycle(3);
}
function button_BACK(){
    console.log("Click: BACK");

    document.getElementById('fade').style.display = "none";
    document.getElementById('about_panel').style.display = "none";
    document.getElementById('user_panel').style.display = "none";
    document.getElementById('upload_panel').style.display = "none";
}

document.getElementById('upload_button').addEventListener("click", button_UPLOAD);
document.getElementById('info_button').addEventListener("click", button_INFO);
document.getElementById('user_button').addEventListener("click", button_USER);
document.getElementById('left_nav_panel').addEventListener("click", button_LEFT);
document.getElementById('right_nav_panel').addEventListener("click", button_RIGHT);
document.getElementById('fade').addEventListener("click", button_BACK);

document.getElementById('nav_0').addEventListener("click", button_LEFT3);
document.getElementById('nav_1').addEventListener("click", button_LEFT2);
document.getElementById('nav_2').addEventListener("click", button_LEFT);
document.getElementById('nav_4').addEventListener("click", button_RIGHT);
document.getElementById('nav_5').addEventListener("click", button_RIGHT2);
document.getElementById('nav_6').addEventListener("click", button_RIGHT3);
