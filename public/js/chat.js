// chat data
const chatbox = document.querySelector('.chateara .chatbox'),
    targetUser = document.getElementById('target'),
    typingarea = document.querySelector('.chateara .typing-area'),
    targetdata = document.querySelector('.chateara header'),
    token = document.querySelector("#_token").value;

var id,chatdisplay;
var user = document.getElementsByClassName('user');
for(let i=0; user.length > i ; i++){
    user[i].onclick = ()=>{ 
        id = user[i].querySelector('input').value;
        chatdisplay = setTimeout(getchat(user[i],id));
    }
}

function getchat(user,id) {
    let req = new XMLHttpRequest();
    req.open('post',"/chatdata", true);
    req.setRequestHeader('X-CSRF-TOKEN',token);
    req.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    req.onload = ()=>{
        if(req.readyState == 4 && req.status == 200){
            let data =  req.response;
            var splited =  data.split('^');
            chatbox.innerHTML = splited[0];
            targetdata.innerHTML = splited[1];
            targetUser.setAttribute('value', id);
            if(!chatbox.classList.contains("active")){
                scrollToBottom(chatbox);
            }
        }
    }
    req.send("target=" + id, '_token={{csrf_token()}}');
}

function scrollToBottom(chatbox){
    chatbox.scrollTop = chatbox.scrollHeight;
}

typingarea.querySelector('button').onclick = (e)=>{
    e.preventDefault();
    if (typingarea.querySelector('.massege').value  != "" && typingarea.querySelector('#target').value  != "" ) {
        sendmsg("/sendmsg");
    }
}
function sendmsg (url) {
        let req = new XMLHttpRequest();
        req.open('post',url, true);
        req.setRequestHeader('X-CSRF-TOKEN',token);
        req.onload = ()=>{
            if(req.readyState == 4 && req.status == 200){
                typingarea.querySelector('.massege').value  = "";
                if(!chatbox.classList.contains("active")){
                    scrollToBottom(chatbox);
                }
            }
        }
        let formData = new FormData(typingarea);
        req.send(formData);
}

var attachbutton = document.getElementById('button-file');
attachbutton.onclick = displaylist;

function displaylist() {
    var attachlist = document.getElementById('file-sender'),
    buttondiv = document.getElementById('attachlink');
    if (attachlist.style.display === "none") {
        attachlist.style.display = "block";
    } else {
        attachlist.style.display = "none";
    }
}

document.getElementById("myimg").onchange = ()=>{
    if (typingarea.querySelector('#target').value  != "" ) {
        addfile("sendimg");
    }
};

document.getElementById("myvideo").onchange = function(){
    if (typingarea.querySelector('#target').value  != "" ) {
        addfile("sendvideo");
    }
};

document.getElementById("myaudio").onchange = function(){
    if (typingarea.querySelector('#target').value  != "" ) {
        addfile("sendaudio");
    }
};

document.getElementById("myfile").onchange = ()=>{
    if (typingarea.querySelector('#target').value  != "" ) {
        addfile("sendfile");
    }
};

function addfile(dirc) {
    let req = new XMLHttpRequest();
    req.open("post",dirc, true);
    req.setRequestHeader('X-CSRF-TOKEN',token);
    req.onload = ()=>{
        if(req.readyState == 4 && req.status == 200){
            if(!chatbox.classList.contains("active")){
                scrollToBottom(chatbox);
            }
        }
    }
    let formData = new FormData(typingarea);
    req.send(formData);
}


// var checkchanges = setInterval(
//     ()=>{
//         

//         let req = new XMLHttpRequest();
//         req.open('post','checkchanges', true);
//         req.setRequestHeader('X-CSRF-TOKEN',token);
//         req.onload = ()=>{
//             if(req.readyState == 4 && req.status == 200){
//                 let data =  req.response;
//                 console.log(data);
//                 if(data == 'new'){
//                     clearTimeout( chatset );
//                     chatset = setTimeout(getchat(user[i]));
//                 }  
//             }
//         }
//         req.send("target=" + id, '_token={{csrf_token()}}');
//     }
// ,500)