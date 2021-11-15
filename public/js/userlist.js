// users data
const searchbar = document.querySelector('#searchbar'),
      searchtext = document.querySelector('.search span'),
      searchbutton = document.querySelector('.users .search button'),
      userslist = document.querySelector('.users .users-list');

searchbutton.onclick = ()=>{
    searchbar.classList.toggle('active');
    searchtext.classList.toggle('active');
    searchbar.focus();
    searchbutton.classList.toggle('active');
    searchbar.value = "";
}

searchbar.onkeyup = ()=>{
    let searchCond = searchbar.value;
    
    searchbar.classList.add('active');
    token = document.querySelector("#_token").value;
    let req = new XMLHttpRequest();
    req.open('post',"/searchchatuser", true);
    req.setRequestHeader('X-CSRF-TOKEN',token);
    req.onload = ()=>{
        if(req.readyState == 4 && req.status == 200){
                let data =  req.response;
                userslist.innerHTML = data;
        }
    }
    req.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    req.send("searchCond=" + searchCond, '_token={{csrf_token()}}');

}

var userdata = setTimeout(()=>{
    let req = new XMLHttpRequest();
    req.open('get','/userdata', true);
    req.onload = ()=>{
        if(req.readyState === XMLHttpRequest.DONE){
            if(req.status === 200){
                let data =  req.response;
                if(!searchbar.classList.contains('active')){
                    userslist.innerHTML = data;
                }
                
            }
        }
    }
    req.send();
});
