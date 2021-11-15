setInterval(()=>{
    window.onbeforeunload = function(){
        let req = new XMLHttpRequest();
        req.open("get","disconnected", true);
        req.send();
    }
},500);

var isonline = document.getElementById('isonline').value;
if(isonline != 1){
    window.onload = function(){
        let req = new XMLHttpRequest();
        req.open("get","reconnected", true);
        req.send();
    }
}

