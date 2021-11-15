@extends('employee.header')

@section('title', 'Chat')

@section('subtitle', 'Chat')

@section('content')

    <div class="chat-container">
        <div class="users">
            <div class="search">
                    <input type="hidden" id="_token" name="_token" value="{{csrf_token()}}">
                    <span class="text">Select user to chat with</span>
                    <input id="searchbar" type="text" placeholder="Enter name to search ...">
                    <button><i class="fa fa-search"></i></button>
            </div>
            <div class="users-list">
                
            </div>
        </div>
        <div class="chateara">
            <header>
                
            </header>
            <div class="chatbox">
            </div>
            <form class="typing-area" method="get" enctype="multipart/form-data" autocomplete="off">
            {{ csrf_field() }}  
                    <input name="target" id="target" type="text"  hidden>
                    <input class="massege" type="text" name="massege" placeholder="Type a massage here...">
                    <div class="file-sender" id="file-sender">
                        <ul class="attachfile" id="ul-file">
                            <li><label class="filebutton">
                                    <i class="far fa-image"></i>
                                    <span><input accept="image/*" type="file" id="myimg" name="img"></span>
                                </label>
                            </li>
                            <li>
                                <label class="filebutton">
                                    <i class="fas fa-video"></i>
                                    <span><input accept="video/*" type="file" id="myvideo" name="video"></span>
                                </label>
                            </li>
                            <li>
                                <label class="filebutton">
                                    <i class="fas fa-headphones"></i>
                                    <span><input accept="audio/*" type="file" id="myaudio" name="audio"></span>
                                </label>
                            </li>
                            <li>
                                <label class="filebutton">
                                    <i style="padding-left: 8px;" class="far fa-file-alt"></i>
                                    <span><input type="file" id="myfile" name="file"></span><a href="http://" target="_blank" rel="noopener noreferrer"></a>
                                </label>
                            </li>
                        </ul>
                    </div>
                    <div class="attachlink" id="attachlink"><a id="button-file"><i class="fas fa-paperclip"></i></a></div>
                    <input type="text" name="last-msg" id="lastmsg" hidden/>
                    <button><i class="fab fa-telegram-plane"></i></button>
            </form>
        </div>
        
    </div>
@endsection
@section('script')
    <script type="text/javascript" src="{{asset('js/userlist.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/chat.js')}}"></script>
@endsection