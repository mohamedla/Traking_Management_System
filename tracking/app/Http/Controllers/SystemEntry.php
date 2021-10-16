<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Exceptions\Handler;
use App\Services\PayUService\Exception;

class SystemEntry extends Controller
{
    
    public function pdfViewer($fileName){
        session_start();
        if(session('user') != null){
                $data = "C:/xampp/htdocs/tracking/public/files/" . $fileName;
                return view("pdfviewer",["data"=>$data]);
        }else{
            return redirect('/');
        }
    }

    public function login(Request $request){
    
	    $user = strtolower($request->user);
	    $password =$request->pass;
        
        $data = DB::table('employees')
        ->where("name", "=", strtolower($user))
        ->get();
        if(!empty($data[0])){
            if(password_verify($password, $data[0]->pass))
            {
                    session_start();
                    session()->put('user',$user);
                    session()->put('id',$data[0]->id);
                    session()->put('isStart',true);
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

    public function logout()
    {

    }
}
