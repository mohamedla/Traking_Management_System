<html>
    <head>
        
    </head>
    <body>
                    <div class="hr"></div>
                        <div class="profile">
                           <form action="test" method="post" enctype="multipart/form-data">
                           {{ csrf_field() }}
                               <div class="center">
                                   <label class="user-color">Profile Picture</label>
                                   <div class="file input">
                                       <span id="src">Select Picture</span>
                                       <input type="file" id="fileImg" name='pic'>
                                   </div>
                                   <!-- user picture -->
                                   <div class="img">
                                       <img src="" class="profile-img" id="profile-img">
                                   </div>
                               </div><div class="hr"></div>
                               <div class="center"><button class="save">Save</button></div>
                           </form>
                       </div>
                    </div>
    </body>
</html>