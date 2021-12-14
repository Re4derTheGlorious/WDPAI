var currPos = 1;
var currAlb = 1;

function cycle(direction){
    const data = {
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
        switchPhoto(photo["path"], currPos+direction);
    });
}

function switchPhoto(newPath, newPos){
    currPos=newPos;
    document.getElementById('contents_panel').style.backgroundImage="url("+newPath+")";
}

function switchAlbum(newAlb){
    currPos = 0;
    currAlb = newAlb;
}