let permissions = [false, false, false, false];
let status = true;

function refresh(permString){
    saveSession(getSession());

    permissions[0] = permString[0]>0?true:false;
    permissions[1] = permString[1]>0?true:false;
    permissions[2] = permString[2]>0?true:false;
    permissions[3] = permString[3]>0?true:false;

    //login form
    document.getElementById('login_button').style.display = getSession().length>0?'none':'initial';
    document.getElementById('register_button').style.display = getSession().length>0?'none':'initial';
    document.getElementById('logoff_button').style.display = getSession().length>0?'initial':'none';
    document.getElementById('login_field').disabled = getSession().length>0?true:false;
    document.getElementById('login_field').value = '';
    document.getElementById('pass_field').disabled = getSession().length>0?true:false;
    document.getElementById('login_field').value = '';



    //buttons
    document.getElementById('upload_button').style.display = permissions[0]==true?'initial':'none';
    //document.getElementById('remove_button').style.display = permissions[1]==true?'initial':'none';
    document.getElementById('fav_button').style.display = permissions[2]==true?'initial':'none';
    document.getElementById('share_button').style.display = permissions[3]==true?'initial':'none';
}

function sign_up(){
    console.log("Click: SIGN_UP")

    status = true;
    const email = document.getElementById('login_field').value;
    const pass = document.getElementById('pass_field').value;

    if(!validate(email, pass)){
        return;
    }

    const data = {
        email: email,
        pass: pass
    };

    fetch("/signUp",{
        method: "POST",
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    }).then(function (response){
        if(!response.ok){
            status = false;
        }
        return response.json();
    }).then(function(response){
        if(status){
            saveSession(response['message']);
            refresh(response['perm']);
            cycle(0);
        }
        else{
            alert(response['message']);
        }
    });

    cycle(0);
}

function log_off(){
    console.log('Click: LOG_OFF');
    saveSession('');
    refresh('0000');
    alert("Logged off!");
}

function sign_in(){
    console.log("Click: SIGN_IN")

    status = true;
    const email = document.getElementById('login_field').value;
    const pass = document.getElementById('pass_field').value;

    if(!validate(email, pass)){
        return;
    }

    const data = {
        email: email,
        pass: pass
    };

    fetch("/signIn",{
        method: "POST",
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    }).then(function (response){
        if(!response.ok){
            status = false;
        }
        return response.json();
    }).then(function(response){
        if(status){
            saveSession(response['message']);
            refresh(response['perm']);
            cycle(0);
        }
        else{
            alert(response['message']);
        }
    });
}

function check(){
    const savedToken = getSession();
    if (savedToken && savedToken.length > 0) {
        const data = {
            token: savedToken
        };

        fetch("/checkSession", {
            method: "POST",
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        }).then(function (response) {
            if (!response.ok) {
                saveSession('');
                return null;
            }
            return response.json();
        }).then(function (response) {
            if (response) {
                refresh(response["message"]);
            }
        });
    }
}

function saveSession(token){
    window.localStorage.setItem('token', token);
    document.getElementById('token_field').value = token;
}

function getSession(){
    const token = window.localStorage.getItem('token');
    return token!=null?token:'';
}

function validate(email, pass){
    if(email.length<3 || !email.includes("@")){
        alert("Invalid email!");
        return false;
    }
    if(pass.length<1){
        alert("No password entered!");
        return false;
    }
    return true;
}

document.getElementById('login_button').addEventListener("click", sign_in);
document.getElementById('register_button').addEventListener("click", sign_up);
document.getElementById('logoff_button').addEventListener("click", log_off);

refresh("0000");
check();