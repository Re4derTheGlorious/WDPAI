function button_UPLOAD(){
    console.log("Click: UPLOAD");
    document.getElementById('fade').style.display = "initial";
    document.getElementById('upload_panel').style.display = "initial";
}
function button_SHARE(){
    console.log("Click: SHARE");
    alert("Album link copied to clipboard!");
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
function button_FAV(){
    console.log("Click: FAV");
}
function button_LEFT(){
    console.log("Click: LEFT");
}
function button_RIGHT(){
    console.log("Click: RIGHT");
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
document.getElementById('fav_button').addEventListener("click", button_FAV);
document.getElementById('share_button').addEventListener("click", button_SHARE);
document.getElementById('left_nav_panel').addEventListener("click", button_LEFT);
document.getElementById('right_nav_panel').addEventListener("click", button_RIGHT);
document.getElementById('fade').addEventListener("click", button_BACK);