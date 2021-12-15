let permissions = [false, false, false, false];

function refresh(permString){
    permissions[0] = permString[0]>0?true:false;
    permissions[1] = permString[1]>0?true:false;
    permissions[2] = permString[2]>0?true:false;
    permissions[3] = permString[3]>0?true:false;

    document.getElementById('upload_button').style.visibility = permissions[0]==true?'initial':'hidden';
    //document.getElementById('remove_button').style.visibility = permissions[1]==true?'initial':'hidden';
    document.getElementById('fav_button').style.visibility = permissions[2]==true?'initial':'hidden';
    document.getElementById('share_button').style.visibility = permissions[3]==true?'initial':'hidden';
}

function sign_up(){
    console.log("Click: SIGN_UP")

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
            alert(response["message"]);
            return null;
        }
        return response.json();
    }).then(function(response){
        if(response){
            saveSession(response['message']);
            refresh(response['perm']);
        }
    });
}

function log_off(){
    saveSession('');
    refresh('0000');
}

function sign_in(){
    console.log("Click: SIGN_IN")

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
            alert(response["message"]);
            return null;
        }
        return response.json();
    }).then(function(response){
        if(response){
            saveSession(response['message']);
            refresh(response['perm']);
        }
    });
}

function check(){
    const savedToken = getSession();
    if(savedToken && savedToken.length>0){
        const data = {
            token: savedToken
        };

        fetch("/checkSession",{
            method: "POST",
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        }).then(function (response){
            if(!response.ok){
                saveSession('');
                return null;
            }
            return response.json();
        }).then(function(response){
            if(response){
                refresh(response["message"]);
            }
        });
    }



}

function saveSession(token){
    window.localStorage.setItem('token', token);
}

function getSession(){
    return window.localStorage.getItem('token');
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