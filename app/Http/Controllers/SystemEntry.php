<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Exceptions\Handler;
use App\Services\PayUService\Exception;
use PhpParser\Node\Stmt\If_;

class SystemEntry extends Controller
{
    public function login(Request $request){
    
	    $user = strtolower($request->user);
	    $password =$request->pass;
        
        $data = DB::table('employees')
                        ->where("username", "=", strtolower($user))
                            ->get();
        if(!empty($data[0])){
            if(password_verify($password, $data[0]->pass))
            {
                    session_start();
                    DB::table('messages')
                        ->where([['sender' , $data[0]->id],['status' , 'send']])
                            ->orWhere([['receiver' , $data[0]->id],['status' , 'send']])
                                ->update(['status' => 'receive']);
                    DB::table('employees')->where("id",$data[0]->id)->update(['status'=>'exist']);
                    session()->put('user',$data[0]->name);
                    session()->put('id',$data[0]->id);
                    session()->put('isStart',true);
                    session()->put('isonline',1);
                    session()->put('groub',(int)$data[0]->groubID);
                    session()->put('pic',($data[0]->img));
                    session()->put('depart',($data[0]->depart));
                    return redirect('empdashboard');
            }
            else
            {
                //wrong pass
                return redirect('/');
            }
    }
        else
        {   
            // echo $user . '<br>';

            $userdata = DB::table('users')
                            ->where("name", "=", strtolower($user))
                                ->get();
            // print $data ;
            if(!empty($userdata[0])){
                
            if(password_verify($password, $userdata[0]->password))
            {
                echo $user . 'all OK' ;
                session_start();
                session()->put('user',$userdata[0]->name);
                session()->put('id',$userdata[0]->id);
                session()->put('isAdmin',true);
                return redirect('dashboard');
            }
            else
            {
                //wrong pass
                return redirect('/');
            }
            }
            //wronge username
        	return redirect('/');
        }
  
           return redirect('/');
    }
   
    public function pdfViewer($fileName){
        session_start();
        if(session('user') != null){
                $data = "C:\Users\moham\Documents\GitHub\Traking_Management_System\public/files/" . $fileName;
                return view("pdfviewer",["data"=>$data]);
        }else{
            return redirect('/');
        }
    }

    public function chat(){
        session_start();
        if(session('user') != null){
                $data = DB::table('employees')->leftJoin("departs", 'employees.depart', '=', 'departs.id')
                                ->select("employees.*","departs.depname")
                                    ->orderBy("departs.depname")->get();
                return view("chat",['pic'=>session('pic'),'groub'=>session('groub'),'name'=>session('user'),]);
        }else{
            return redirect('/');
        }
    }

    public function searchchatuser(Request $request){
        session_start();
        if(session('user') != null){
            $data=DB::table('employees')
                        ->where([["name" ,"like", "%{$request->searchCond}%"],["employees.id","!=",session('id')]])
                            ->leftJoin("departs", 'employees.depart', '=', 'departs.id')
                                ->select("employees.*", "departs.depname as depname")
                                    ->orderBy("departs.depname")
                                        ->get();
            if($request->searchCond == ''){
                $data=DB::table('employees')
                        ->where("employees.id","!=",session('id'))
                            ->leftJoin("departs", 'employees.depart', '=', 'departs.id')
                                ->select("employees.*", "departs.depname as depname")
                                    ->orderBy("departs.depname")
                                        ->get();
            }
            
            $output = $this->displayUsers($data);
            echo $output;
        }else{
            return redirect('/');
        }
    }

    public function userdata(){
        session_start();
        if(session('user') != null){
            $data=DB::table('employees')
                        ->where("employees.id","!=",session('id'))
                            ->leftJoin("departs", 'employees.depart', '=', 'departs.id')
                                ->select("employees.*", "departs.depname as depname")
                                    ->orderBy("departs.depname")
                                        ->get();
            
            $output = $this->displayUsers($data);
            echo $output;
        }else{
            return redirect('/');
        }
    }

    static function displayUsers($data)
    {
        $output = '';
        $departement = $data[0]->depname;
        $output .= '<div class="userdep"><span>'.$data[0]->depname.'</span></div>';
        foreach ($data as $user) {
            $sender = '';
            if($departement != $user->depname){
                $output .= '<div class="userdep"><span>'.$user->depname.'</span></div>';
                $departement = $user->depname;
            }

            $lastmessage=DB::table('messages')
                                ->where([['sender' , session('id')],['receiver' , $user->id]])
                                    ->orWhere([['sender' , $user->id],['receiver' , session('id')]])
                                        ->orderBy("time","desc")->limit(1)->get();
            if ($lastmessage->count() > 0 ) {
                $msg = $lastmessage[0]->msg;
                ($lastmessage[0]->sender == session('id') )? $sender = 'You: ' : $sender = '';
                (strlen($msg) > 20 ) ? $msg = substr($msg, 0, 20). '...' : $msg = $msg;
            } else {
                $msg = 'No messages yet';
            }
            
            

            ($user->status != 'left')? $offline = '': $offline = 'offline';

            $unseenmsgs=DB::table('messages')
                                ->where([['sender' , $user->id],['receiver' , session('id')],['status' , 'receive']])
                                        ->get();
            ($unseenmsgs->count() > 0)? $noUnseenMsg = '': $noUnseenMsg = 'none';
            
            $output .= ' <a class="user">
                            <input type="hidden" value="'.$user->id.'">
                            <div class="user-data">
                                <img src="http://localhost:8000/images/'.$user->img.'" alt="">
                                <div class="details">
                                    <span>'.$user->name.'</span>
                                    <p>'.$sender.$msg.'</p>
                                </div>
                            </div>
                            <div class="status-icon">
                            <div class="unseen-msg '.$noUnseenMsg.'"><i class="fas fa-circle"><span>'.$unseenmsgs->count().'</span></i></div>
                            <div class="status-dot '.$offline.'"><i class="fas fa-circle"></i></div>
                            </div>        
                        </a>';
            
        }
        return $output;
    }

    public function chatdata(Request $request)
    {
        session_start();
        if(session('user') != null){
            $targetdata = DB::table('employees')->where('id',$request->target)->get();
            $data=DB::table('messages')
                                ->where([['sender' , session('id')],['receiver' , $request->target]])
                                    ->orWhere([['sender' , $request->target],['receiver' , session('id')]])
                                        ->orderBy('time','asc')
                                            ->get();
            if($data->count() > 0){
                DB::table('messages')
                                ->where([['sender' , $request->target],['receiver' , session('id')],['status' , 'receive']])
                                    ->update(['status' => 'seen']);
                $output = "";
                foreach ($data as $message) {
                    $msg = "<p>error in download the Message</p>";
                    switch($message->msg_type){
                        case "txt":
                            $msg = "<p>".$message->msg."</p>";
                        break;
                        case "image":
                            $msg = "<img class='msg-img'  src='http://localhost:8000/images/".$message->msg."' alt='".$message->msg."' title='".$message->msg."'>";
                        break;
                        case "video":
                            $msg = "<video src='http://localhost:8000/videos/".$message->msg."' id='msg-ved' class='msg-ved' 
                            width='320' height='240' preload='metadata' controls></video>";
                        break;
                        case "audio":
                            $msg = "<audio src='http://localhost:8000/audios/".$message->msg."' id='msg-aud' class='msg-aud' 
                             preload='metadata' controls></audio>";
                        break;
                        default:
                            $msg = "<p><a href='http://localhost:8000/files/".$message->msg."' target='_blank'>".$message->msg."</a></p>";
                        break;
                    }
                    switch($message->status){
                        case "seen":
                            $msg_status = "fas fa-check-double blue";
                        break;
                        case "receive":
                            $msg_status = "fas fa-check-double gray";
                        break;
                        default:
                            $msg_status = "fas fa-check gray";
                        break;
                    }
                    if($message->sender == session('id')){
                        $output .= "<div class='chat outgoing'>
                                    <div class='details'>
                                        ".$msg."
                                    </div>
                                </div>
                                <div class='time outgoing-time'>
                                        <p>".$message->time."</p>
                                        <i class='".$msg_status."'></i>
                                </div><div></div>";
                    }else{
                        $output .= "<div class='chat ingoing'>
                                    <img class='user-img' src='http://localhost:8000/images/".$targetdata[0]->img."' alt=''>
                                    <div class='details'>
                                    ".$msg."
                                    </div>
                                </div>
                                <div class='time ingoing-time'>
                                        <p>".$message->time."</p>
                                </div>";
                    }
                }
            }else{
                $output = '<center>No messages yet <br> say Hi &#128075;</center>';
            }
            $output .= "^
                    <img src='http://localhost:8000/images/".$targetdata[0]->img."' alt=''>
                    <div class='details'>
                        <span>".$targetdata[0]->name."</span>
                        <p>". ucfirst($targetdata[0]->status)."</p>
                    </div>";
            echo $output;
        }else{
            return redirect('/');
        }
    }

    public function checkchanges(Request $request)
    {
        session_start();
        if(session('user') != null){
            // $targetdata = DB::table('employees')->where('id',$request->target)->get();
            print $request->target;
            echo 'checkchanges';
        }else{
            return redirect('/');
        }
    }

    public function sendmsg(Request $request)
    {
        session_start();
        if(session('user') != null){
            $targetstatus = DB::table('employees')->where('id',$request->target)->get('status');
            if($targetstatus[0]->status != 'left'){
                $status = 'receive';
            } else {
                $status = 'send';
            }
            DB::table('messages')->insert(
                [
                    'sender' => session('id'),
                    'receiver' => $request->target,
                    'msg' => $request->massege,
                    'time' => now(),
                    'status' => $status,
                ]
            );
        }else{
            return redirect('/');
        }
    }
    
    public function sendfile(Request $request)
    {
        session_start();
        if(session('user') != null){
            $this->sendFiles($request,'file');
        }else{
            return redirect('/');
        }
    }

    public function sendimg(Request $request)
    {
        session_start();
        if(session('user') != null){
            $this->sendFiles($request,'img');
        }else{
            return redirect('/');
        }
    }

    public function sendvideo(Request $request)
    {
        session_start();
        if(session('user') != null){
            $this->sendFiles($request,'video');
        }else{
            return redirect('/');
        }
    }

    public function sendaudio(Request $request)
    {
        session_start();
        if(session('user') != null){
            $this->sendFiles($request,'audio');
        }else{
            return redirect('/');
        }
    }

    public function sendFiles($request,$inputname)
    {
        $targetstatus = DB::table('employees')->where('id',$request->target)->get('status');
            if($targetstatus[0]->status != 'left'){
                $status = 'receive';
            } else {
                $status = 'send';
            }
            $file_name = $_FILES[$inputname]['name'];
            $file_type = $_FILES[$inputname]['type'];
            $temp_name = $_FILES[$inputname]['tmp_name'];
            $file_explode = explode('/', $file_type);
            $extention = end($file_explode);
            $time = time();
            $new_file_name = $time . $file_name;
            $type = $file_explode[0];
            DB::table('messages')->insert(
                [
                    'sender' => session('id'),
                    'receiver' => $request->target,
                    'msg' => $new_file_name,
                    'time' => now(),
                    'status' => $status,
                    'msg_type' => $type,
                    'msg_esten' => $extention,
                ]
            );
            switch ($type) {
                case 'image':
                    move_uploaded_file($temp_name,'C:\Users\moham\Documents\GitHub\Traking_Management_System\public\images/'. $new_file_name);
                    break;
                case 'video':
                    move_uploaded_file($temp_name,'C:\Users\moham\Documents\GitHub\Traking_Management_System\public\videos/'. $new_file_name);
                    break;
                case 'audio':
                    move_uploaded_file($temp_name,'C:\Users\moham\Documents\GitHub\Traking_Management_System\public\audios/'. $new_file_name);
                    break;
                default:
                    move_uploaded_file($temp_name,'C:\Users\moham\Documents\GitHub\Traking_Management_System\public\files/'. $new_file_name);
                    break;
            }
    }

    public function disconnected()
    {
        session_start();
        if(session('user') != null){
            session()->put('isonline',0);
            DB::table('employees')->where("id", session('id'))->update(['status' => 'left']);
        }else{
            return redirect('/');
        }
    }

    public function reconnected()
    {
        session_start();
        if(session('user') != null){
            session()->put('isonline',1);
            DB::table('employees')->where("id", session('id'))->update(['status' => 'exist']);
        }else{
            return redirect('/');
        }
    }
    
    public function logout()
    {

    }
}
