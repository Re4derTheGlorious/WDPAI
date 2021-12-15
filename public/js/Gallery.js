var currPos = 1;
var currAlb = 1;


function likePhoto(){
    console.log("Click: FAV");
    const data = {
        "currPos": currPos,
        "currAlb": currAlb,
        token: getSession()
    };

    fetch("/likePhoto",{
        method: "POST",
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    }).then(function (response){
        return response.json();
    }).then(function(response){
        if(currPos==response['pos']){
            refreshAlbumUI(response["message"]);
        }
    });

    if(document.getElementById("fav_icon").style.display=='initial'){
        document.getElementById("fav_icon").style.display='none';
    }
    else{
        document.getElementById("fav_icon").style.display='initial';
    }
}

function initGallery(){
    currPos = Math.floor(Math.random() * 10);

    if(getParam('currAlb')){
        switchAlbum(getParam('currAlb'));
    }


    const data = {
        token: getSession(),
        currPos: this.currPos,
        currAlb: this.currAlb,
        dir: 0
    };

    fetch("/fetchPhoto",{
        method: "POST",
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    }).then(function (response){
        return response.json();
    }).then(function(photo){
        switchPhoto(photo["path"], currPos, photo["faved"]);
    });
}

function cycle(direction){
    const data = {
        token: getSession(),
        currPos: this.currPos,
        currAlb: this.currAlb,
        dir: direction
    };

    fetch("/fetchPhoto",{
        method: "POST",
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    }).then(function (response){
        return response.json();
    }).then(function(photo){
        switchPhoto(photo["path"], currPos+direction, photo["faved"]);
    });
}

function switchPhoto(newPath, newPos, isFaved){
    currPos=newPos;
    document.getElementById('contents_panel').style.backgroundImage="url("+newPath+")";

    refreshAlbumUI(isFaved);
}

function switchAlbum(newAlb){
    currPos = 0;
    currAlb = newAlb;
}

function refreshAlbumUI(faved){
    document.getElementById("fav_icon").style.display=(faved==1)?'none':'initial';
}

function getLink(){
    console.log("Click_SHARE");

    const data = {
        token: getSession()
    };

    fetch("/getAlbum",{
        method: "POST",
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    }).then(function (response){
        return response.json();
    }).then(function(response){
        var url = window.location.href.split('?')[0]+'?currAlb='+response["message"];

        setClipboard(url);
    });
}

function setClipboard(text) {
    var type = "text/plain";
    var blob = new Blob([text], { type });
    var data = [new ClipboardItem({ [type]: blob })];

    navigator.clipboard.write(data).then(
        function () {
            alert('Album link copied to clipboard!');
        },
        function () {
            alert('Cannot copy. Browser not supported?');
        }
    );
}


function getParam(param){
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(param);
}

document.getElementById('fav_button').addEventListener("click", likePhoto);
document.getElementById('share_button').addEventListener("click", getLink);

initGallery();