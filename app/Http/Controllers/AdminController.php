<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\departs;
use App\Models\employees;
use App\Models\leaving;
use App\Models\notice;
use App\Models\quote;
use Illuminate\Support\Facades\Redis;

class AdminController extends Controller
{

    public function index(){
        session_start();
        if(session('user') != null){
            $admin = DB::table('users')->where('name','=',session('user'))->get();
            if($admin->count() > 0){
                return redirect('/dashboard');
            }else{
                return redirect('/empdashboard');
            }
        }else{
            return redirect('/login');
        }
    }
    
    public function dashData(){
        session_start();
        if(session('user') != null){
            $admin = DB::table('users')->where('name',session('user'))->get();
            if($admin->count() > 0){
                $quotes=DB::table('quote')->inRandomOrder();
                if($quotes->count() > 0){
                    $quote=$quotes->first();
                }else{
                    DB::table('quote')->insert([

                    [
                        'quote' => 'Welocome To My Humble Website',
                        'person' => 'Admin',            ]
                    ]);
                    $quote=DB::table('quote')->first();
                }
                $empcount=DB::table('employees')->count();
                $departcount=DB::table('departs')->count();
                $presentcount=DB::table('employees')->where('status','Working')->count();
                $onleavecount=DB::table('employees')->where('status','onleave')->count();
                //return $empcount;
                return view("admin/dashboard",compact('quote','empcount','departcount','presentcount','onleavecount'));
            }else{
                return redirect('/');
            }
        }else{
            return redirect('/');
        }
    	
    }
    //test page
    public function test(){
        session_start();
        if(session('user') != null){
            $total = DB::table('departs')->where('id', 1)->get('totemp');
            echo $total;
            echo $total[0]->totemp . "<br>";
            echo is_int((int)$total[0]->totemp);
        }else{
            echo 'LOL';
        }
    }
    //end
    public function addemployee(Request $request){

        session_start();
        if(session('user') != null){
            $admin = DB::table('users')->where('name',session('user'))->get();
            if($admin->count() > 0){
                $store_path = 'C:\Users\moham\Documents\GitHub\Traking_Management_System\public\images/';
                $pic_name = $_FILES['pic']['name'];
                $stor_name  = $request->username. '.'.explode('.',$pic_name)[1];
                $stor_tmp = $_FILES['pic']['tmp_name'];
                move_uploaded_file($stor_tmp, $store_path . $stor_name);

                DB::table('employees')->insert([
                    [
                        'username' => strtolower($request->username),
                        'name' => ucfirst($request->name),
                        'email' => strtolower($request->email),
                        'pass' => Hash::make($request->pass),
                        'img' => $stor_name,
                        'gender' => strtolower($request->gender),
                        'dob' => $request->date,
                        'address'=> strtoupper($request->address),
                        'phone' => $request->phone,
                        'depart' => (int)$request->depart,
                    ]
                ]);

                $empID = DB::table('employees')->where('name',$request->name)->get('id');
                DB::table('emp_depart')->insert([
                    [
                        'emp_id' => $empID[0]->id,
                        'dep_id' => $request->depart,
                    ]
                    ]);
                $employeeNum = DB::table('departs')->where('id',(int)$request->depart)->get('totemp');
                DB::table('departs')->where('id',(int)$request->depart)->update(['totemp'=> ((int)$employeeNum[0]->totemp + 1)]);
                return redirect("/addEmployee");
            }else{
                return redirect('/');
            }
        }else{
            return redirect('/');
        }

        
    }

    public function updateEmployee(Request $request,$id)
    {
        session_start();
        if(session('user') != null){
            $admin = DB::table('users')->where('name',session('user'))->get();
            if($admin->count() > 0){
                $emp = employees::find($id);
                $emp->username = strtolower($request->username);
                $emp->name = strtolower($request->name);
                $emp->dob = $request->date;
                $emp->email = strtolower($request->email);
                $emp->gender = strtolower($request->gender);
                $emp->depart = (int)$request->depart;
                $emp->phone = $request->phone;
                $emp->address = strtoupper($request->address);
                if($request->pass != ""){
                    $emp->pass = Hash::make($request->pass);
                }
                $emp->save();
                return redirect("/manageEmployee");
            }else{
                return redirect('/');
            }
        }else{
            return redirect('/');
        }
        
    }

    public function addDepart(Request $request){

        session_start();
        if(session('user') != null){
            $admin = DB::table('users')->where('name',session('user'))->get();
            if($admin->count() > 0){
                DB::table('departs')->insert([
                    [
                        'depname' => $request->depart,
                    ]
                    ]);
                
                
                return redirect("/addDepart");
            }else{
                return redirect('/');
            }
        }else{
            return redirect('/');
        }

        
    }

    public function searchemp(Request $request){

        session_start();
        if(session('user') != null){
            $admin = DB::table('users')->where('name',session('user'))->get();
            if($admin->count() > 0){
                
                switch ($request->type) {
                    case '0':
                        $data=DB::table('employees')
                            ->where('departs.depname',$request->search)
                                ->leftJoin("departs", 'employees.depart', '=', 'departs.id')
                                    ->select("employees.*", "departs.depname as depname")
                                        ->get();
                        break;
                    case '1':
                        $data=DB::table('employees')
                            ->where('employees.name',$request->search)
                                ->leftJoin("departs", 'employees.depart', '=', 'departs.id')
                                    ->select("employees.*", "departs.depname as depname")
                                        ->get();
                        break;
                    case '2':
                        $data=DB::table('employees')
                            ->where('employees.id',$request->search)
                                ->leftJoin("departs", 'employees.depart', '=', 'departs.id')
                                    ->select("employees.*", "departs.depname as depname")
                                        ->get();
                        break;
                }
                // print $data;
                return view("admin/manageEmployee",["data"=>$data]);
            }else{
                return redirect('/');
            }
        }else{
            return redirect('/');
        }

    }

    public function empManage()
    {
        session_start();
        if(session('user') != null){
            $admin = DB::table('users')->where('name',session('user'))->get();
            if($admin->count() > 0){
                //listing posts
                // $date2 = date("Y-m-d");
                $data=DB::table('employees')
                            ->leftJoin("departs", 'employees.depart', '=', 'departs.id')
                                ->select("employees.*", "departs.depname as depname")
                                    ->orderBy("departs.depname")
                                        ->orderBy("employees.name")
                                            ->get();
                return view("admin/manageEmployee",["data"=>$data,]);
            }else{
                return redirect('/');
            }
        }else{
            return redirect('/');
        }
    }

     public function departManage()
    {

        session_start();
        if(session('user') != null){
            $admin = DB::table('users')->where('name',session('user'))->get();
            if($admin->count() > 0){
                $data=DB::table('departs')
                            ->leftJoin('employees', 'departs.head_id', '=', 'employees.id')
                                ->select('departs.*','employees.name as empname')
                                ->orderBy('departs.depname')
                                    ->get();
                return view("admin/manageDeparts",["data"=>$data]);
            }else{
                return redirect('/');
            }
        }else{
            return redirect('/');
        }
    }

    public function addNotice(Request $request){

        session_start();
        if(session('user') != null){
            $admin = DB::table('users')->where('name',session('user'))->get();
            if($admin->count() > 0){
                DB::table('notice')->insert([
                    [
                        //'id'=> $request->id,
                        'title' => $request->title,
                        'description' => $request->desc,
                        'date' => now()
                    ]
                        ]);
                    return redirect("/addNotice");
            }else{
                return redirect('/');
            }
        }else{
            return redirect('/');
        }
    }

    public function noticeManage()
    {
        
        session_start();
        if(session('user') != null){
            $admin = DB::table('users')->where('name',session('user'))->get();
            if($admin->count() > 0){
                //listing posts
                $data=DB::table('notice')->get();
                return view("admin/mangeNotice",["data"=>$data]);
            }else{
                return redirect('/');
            }
        }else{
            return redirect('/');
        }
    }

    public function addQuote(Request $request){

        session_start();
        if(session('user') != null){
            $admin = DB::table('users')->where('name',session('user'))->get();
            if($admin->count() > 0){
                $welQuote = DB::table('quote')->where('id',1)->get();
                if($welQuote->count() > 0){
                    DB::table("quote")->delete(1);
                }
                DB::table('quote')->insert([

                [
                    'quote' => $request->quote,
                    'person' => $request->person
                ]
                    ]);
                return redirect("/addQuite");
            }else{
                return redirect('/');
            }
        }else{
            return redirect('/');
        }
    }

    public function QManage()
    {

        session_start();
        if(session('user') != null){
            $admin = DB::table('users')->where('name',session('user'))->get();
            if($admin->count() > 0){
                //listing posts
                $data=DB::table('quote')->get();
                return view("admin/manageQuite",["data"=>$data]);

            }else{
                return redirect('/');
            }
        }else{
            return redirect('/');
        }
    }


    public function dailyAttend(Request $request)
    {
        session_start();
        if(session('user') != null){
            $admin = DB::table('users')->where('name',session('user'))->get();
            if($admin->count() > 0){
                //listing posts
                $dep = $request->dep;
                $date = $request->date;
                if($dep == 'all'){
                    $data=DB::table('attendance')
                    ->join('employees', 'employees.id', '=', 'attendance.emp_id')
                    ->where('attendance.date', '=', $date)
                    ->get();
                }
                else{
                    $data=DB::table('attendance')
                    ->join('employees', 'employees.id', '=', 'attendance.emp_id')
                    ->where([
                            ['attendance.date', '=', $date],
                            ['employees.depart', '=', $dep],
                        ])->get();
                }
                return view("admin/dailyAttendance",["data"=>$data]);
            }else{
                return redirect('/');
            }
        }else{
            return redirect('/');
        }
    }

    public function dailyAttendAll()
    {
        session_start();
        if(session('user') != null){
            $admin = DB::table('users')->where('name',session('user'))->get();
            if($admin->count() > 0){
                $data=DB::table('attendance')
                            ->join('employees', 'employees.id', '=', 'attendance.emp_id')
                                ->get();
                return view("admin/dailyAttendance",["data"=>$data]);
            }else{
                return redirect('/');
            }
        }else{
            return redirect('/');
        }
    }

    public function addLeave(Request $request){

        session_start();
        if(session('user') != null){
            $admin = DB::table('users')->where('name',session('user'))->get();
            if($admin->count() > 0){
                $empName= $request->name;
                $data = DB::table('employees')->where('name','=',$empName)->get();
                $id = $data[0]->id;
                DB::table('leaving')->insert([
                [
                    'status' => $request->status,
                    'comment' => $request->comment,
                    'type' => $request->type,
                    'timefrom' => $request->from,
                    'timeto' => $request->to,
                    'day' => $request->date,
                    'emp_id' => $id
                ]
                ]);
                return redirect("/addLeave");
            }else{
                return redirect('/');
            }
        }else{
            return redirect('/');
        }
    }


    public function leavingManage()
    {
        session_start();
        if(session('user') != null){
            $admin = DB::table('users')->where('name',session('user'))->get();
            if($admin->count() > 0){
                $data=DB::table('leaving')
                            ->join('employees','leaving.emp_id','=','employees.id')
                                ->select('leaving.*', 'employees.name')
                                    ->get();
                return view("admin/manageLeave",["data"=>$data]);
            }else{
                return redirect('/');
            }
        }else{
            return redirect('/');
        }
    }

    public function editDepart($id)
    {
        session_start();
        if(session('user') != null){
            $admin = DB::table('users')->where('name',session('user'))->get();
            if($admin->count() > 0){
                $depart = DB::table('departs')->where('id',$id)->get();
                $employee = DB::table('employees')->where('depart',$id)->select("employees.id","employees.name")->get();
                // $head = DB::table('emp_depart')->where('dep_id',$id)->where('is_head',true)->get('emp_id');
                return view("admin/editDepart",['data' => $depart,'emps' => $employee,'head' => $depart[0]->head_id ]);
            }else{
                return redirect('/');
            }
        }else{
            return redirect('/');
        }

    }

    public function updateDepart(Request $request,$id,$oldhead)
    {
        session_start();
        if(session('user') != null){
            $admin = DB::table('users')->where('name',session('user'))->get();
            if($admin->count() > 0){
                DB::table('departs')->where('id',$id)->update(['depname' => $request->depart]);
                if($request->headid != 0 && $request->headid != $oldhead){
                    if( $oldhead != 0){
                        DB::table("employees")->where('id',$request->headid)->update(['groubID' => 1]);
                        DB::table("employees")->where('id',$oldhead)->update(['groubID' => 0]);
                        DB::table('departs')->where('id',$id)->update(['head_id' => (int)$request->headid]);

                    }else{
                        DB::table("employees")->where('id',$request->headid)->update(['groubID' => 1]);
                        DB::table('departs')->where('id',$id)->update(['head_id' => (int)$request->headid]);
                    }
                }
                return redirect("/manageDeparts");
            }else{
                return redirect('/');
            }
        }else{
            return redirect('/');
        }
        
    }

    public function editEmployee($id)
    {
        session_start();
        if(session('user') != null){
            $admin = DB::table('users')->where('name',session('user'))->get();
            if($admin->count() > 0){
                $data = DB::table('employees')->where('id','=',$id)->get();
                $depart = DB::table('departs')->get();
                return view("admin/editEmployee",['data' => $data , 'depart' => $depart]);
                // return view("admin/editEmployee",compact('id','name','email','address','depart','phone'));
            }else{
                return redirect('/');
            }
        }else{
            return redirect('/');
        }
    }

    

    public function editLeave($id,$name,$type,$timefrom,$timeto,$status,$comment)
    {
        session_start();
        if(session('user') != null){
            $admin = DB::table('users')->where('name',session('user'))->get();
            if($admin->count() > 0){
                return view("admin/editLeave",compact('id','name','type','timefrom','timeto','status','comment'));
            }else{
                return redirect('/');
            }
        }else{
            return redirect('/');
        }
    }

    public function updateLeave(Request $request,$id)
    {
        session_start();
        if(session('user') != null){
            $admin = DB::table('users')->where('name',session('user'))->get();
            if($admin->count() > 0){
                $name = $request->emp;
                echo $name;
                $data=DB::table('employees')->where('name','=',$name)
                ->get();
                $emp_id = $data[0]->id;
                    $leav = leaving::find($id);
                    $leav->emp_id = $emp_id;
                    $leav->status = $request->status;
                    $leav->type = $request->type;
                    $leav->timefrom = $request->timefrom;
                    $leav->timeto = $request->timeto;
                    $leav->comment = $request->comment;
                    $leav->save();
                    return redirect("/manageLeave");
            }else{
                return redirect('/');
            }
        }else{
            return redirect('/');
        }
    }

    public function editNotice($id,$title,$description)
    {
        session_start();
        if(session('user') != null){
            $admin = DB::table('users')->where('name',session('user'))->get();
            if($admin->count() > 0){
                return view("admin/editNotice",compact('id','title','description'));
            }else{
                return redirect('/');
            }
        }else{
            return redirect('/');
        }
    }

    public function updateNotice(Request $request,$id)
    {
        session_start();
        if(session('user') != null){
            $admin = DB::table('users')->where('name',session('user'))->get();
            if($admin->count() > 0){
                $note = notice::find($id);
                $note->title = $request->title;
                $note->description = $request->description;
                $note->save();
                return redirect("/manageNotice");
            }else{
                return redirect('/');
            }
        }else{
            return redirect('/');
        }
    }
    public function editQuote($id,$quote,$person)
    {
        session_start();
        if(session('user') != null){
            $admin = DB::table('users')->where('name',session('user'))->get();
            if($admin->count() > 0){
                return view("admin/editQuite",compact('id','quote','person'));
            }else{
                return redirect('/');
            }
        }else{
            return redirect('/');
        }
    }

    public function updateQuote(Request $request,$id)
    {
        session_start();
        if(session('user') != null){
            $admin = DB::table('users')->where('name',session('user'))->get();
            if($admin->count() > 0){
                $quote = quote::find($id);
                $quote->quote = $request->quote;
                $quote->person = $request->person;
                $quote->save();
                return redirect("/manageQuite");
            }else{
                return redirect('/');
            }
        }else{
            return redirect('/');
        }
    }

    public function empDetails($id)
    {
        session_start();
        if(session('user') != null){
            $admin = DB::table('users')->where('name',session('user'))->get();
            if($admin->count() > 0){
                $data = DB::table("employees")
                                ->where("id", "=" , $id)
                                    ->get();
                return view("admin/employeeDetaills",["data"=>$data]);
            }else{
                return redirect('/');
            }
        }else{
            return redirect('/');
        }
    }

    public function deleteDepart($id)
    {
        session_start();
        if(session('user') != null){
            $admin = DB::table('users')->where('name',session('user'))->get();
            if($admin->count() > 0){
                DB::table("departs")->delete($id);
                return redirect("/manageDeparts");
            }else{
                return redirect('/');
            }
        }else{
            return redirect('/');
        }
    }

    public function deleteEmp($id)
    {
        session_start();
        if(session('user') != null){
            $admin = DB::table('users')->where('name',session('user'))->get();
            if($admin->count() > 0){
                DB::table("employees")->delete($id);
                return redirect("/manageEmployee");
            }else{
                return redirect('/');
            }
        }else{
            return redirect('/');
        }
    }

    public function deleteNote($id)
    {
        session_start();
        if(session('user') != null){
            $admin = DB::table('users')->where('name',session('user'))->get();
            if($admin->count() > 0){
                DB::table("notice")->delete($id);
                return redirect("/manageNotice");
            }else{
                return redirect('/');
            }
        }else{
            return redirect('/');
        }
        
    }

    public function deleteQuote($id)
    {
        session_start();
        if(session('user') != null){
            $admin = DB::table('users')->where('name',session('user'))->get();
            if($admin->count() > 0){
                DB::table("quote")->delete($id);
                return redirect("/manageQuite");
            }else{
                return redirect('/');
            }
        }else{
            return redirect('/');
        }
        
    }

    public function changePass(Request $request)
    {
        session_start();
        if(session('user') != null){
            $admin = DB::table('users')->where('name',session('user'))->get();
            if($admin->count() > 0){
                $old = $request->old;
                $new = $request->new;
                $data=DB::table('employees')->where('name','=', session('user'))
                ->get();
                $emp_id = $data[0]->id;
                $oldPass = $data[0]->pass;
                if(password_verify($old, $oldPass))
                {
                    $emp = employees::find($emp_id);
                    $emp->pass = Hash::make($new);
                    $emp->save();
                    return redirect("/changePass");
                }else{
                    echo "old pass is incorrect";
                    echo session('user');
                }
            }else{
                return redirect('/');
            }
        }else{
            return redirect('/');
        }
    }
    public function addEmpformat()
    {
        session_start();
        if(session('user') != null){
            $admin = DB::table('users')->where('name',session('user'))->get();
            if($admin->count() > 0){
                $data = DB::table("departs")->get();
                return view("admin/addEmployee",["data"=>$data]);
            }else{
                return redirect('/');
            }
        }else{
            return redirect('/');
        }
    }

    public function addProjectForm(){
        session_start();
        if(session('user') != null){
            $admin = DB::table('users')->where('name',session('user'))->get();
            if($admin->count() > 0){
                $data = DB::table("departs")->get();
                return view("admin/addproject",["data"=>$data]);
            }else{
                return redirect('/');
            }
        }else{
            return redirect('/');
        }
    }

    public function addProject(Request $request){
        session_start();
        if(session('user') != null){
            $admin = DB::table('users')->where('name',session('user'))->get();
            if($admin->count() > 0){
                $store_path = 'C:\Users\moham\Documents\GitHub\Traking_Management_System\public\files/';
                $pic_name = $_FILES['descrip']['name'];
                $stor_name  = $request->name. '.'.explode('.',$pic_name)[1];
                $stor_tmp = $_FILES['descrip']['tmp_name'];
                DB::table('projects')->insert(
                    [

                        'proname' => $request->name,
                        'depart' => $request->depart,           
                        'startline' => $request->startline,           
                        'endline' => $request->deadline,
                        'descriFile' => str_replace(' ', '', $stor_name),           

                    ]);
                move_uploaded_file($stor_tmp, $store_path . str_replace(' ', '', $stor_name));
                return redirect('/addproject');
            }else{
                return redirect('/');
            }
        }else{
            return redirect('/');
        }
    }

    public function manageProject(){
        session_start();
        if(session('user') != null){
            $admin = DB::table('users')->where('name',session('user'))->get();
            if($admin->count() > 0){
                $data = DB::table('projects')
                        ->leftJoin('departs', 'projects.depart', '=', 'departs.id')
                            ->select('projects.*','departs.depname')
                                ->orderBy('projects.id', 'desc')
                                    ->get();
                return view("admin/manageprojects",["data"=>$data]);
            }else{
                return redirect('/');
            }
        }else{
            return redirect('/');
        }
    }

    public function editProject($id){
        session_start();
        if(session('user') != null){
            $admin = DB::table('users')->where('name',session('user'))->get();
            if($admin->count() > 0){
                $data = DB::table('projects')->where('id',$id)->get();
                $dep = DB::table('departs')->get();
                return view('admin/editProject',['data' => $data, 'dep' => $dep]);
            }else{
                return redirect('/');
            }
        }else{
            return redirect('/');
        }
    }

    public function updateProject(Request $request,$id){
        session_start();
        if(session('user') != null){
            $admin = DB::table('users')->where('name',session('user'))->get();
            if($admin->count() > 0){
                if($request->descrip == null){
                    DB::table('projects')->where('id',$id)->update([
                        'proname' => $request->name,
                        'depart' => $request->depart,
                        'startline' => $request->start,
                        'endline' => $request->end,
                    ]);
                }else{
                    $store_path = 'C:\xampp\htdocs\tracking\public\files/';
                    $pic_name = $_FILES['descrip']['name'];
                    $stor_name  = $request->name. '.'.explode('.',$pic_name)[1];
                    $stor_tmp = $_FILES['descrip']['tmp_name'];
                    DB::table('projects')->where('id',$id)->update([
                        'proname' => $request->name,
                        'depart' => $request->depart,
                        'startline' => $request->start,
                        'endline' => $request->end,
                        'descriFile' => $stor_name,
                    ]);
                    move_uploaded_file($stor_tmp, $store_path . str_replace(' ', '', $stor_name));
                }
                return redirect('manageproject');
            }else{
                return redirect('/');
            }
        }else{
            return redirect('/');
        }
    }

    public function delProject($id){
        session_start();
        if(session('user') != null){
            $admin = DB::table('users')->where('name',session('user'))->get();
            if($admin->count() > 0){
                 DB::table('projects')->delete($id);
                 return redirect('manageproject');
            }else{
                return redirect('/');
            }
        }else{
            return redirect('/');
        }
    }

}
