<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GrahamCampbell\ResultType\Success;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Route;

use function PHPUnit\Framework\isTrue;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $currentUserId;
    
    public function index()
    {
        session_start();
        if(session('id') != null){
            $notice = DB::table('notice')->get();
            $quote = DB::table('quote')->inRandomOrder()->first();
            return view('employee.dashboard',
                [
                    'isStart'=>session('isStart'),
                    'name'=>session('user'),
                    'pic'=>session('pic'),
                    'groub'=>(int)session('groub'),
                    'notices'=>$notice,
                    'quotes'=>$quote
                ]
            );
        }else{
            return redirect('/');
        }
        
    }

    public function updateUser(Request $request)
    {
        session_start();
        if(session('user') != null){
            try {
                
                $store_path = 'C:\xampp\htdocs\tracking\public\images/';
                $pic_name = $_FILES['pic']['name'];
                $stor_name  = session('user'). '.'.explode('.',$pic_name)[1];
                $stor_tmp = $_FILES['pic']['tmp_name'];
                if(move_uploaded_file($stor_tmp, $store_path . $stor_name)){
                    $user = DB::table('employees')
                                    ->where('name',session('user'))
                                        ->update([
                                                    'img' => $stor_name,
                                                ]);
                    return redirect('emprofile');
                }else{
                    return redirect('emprofile');
                }
            } catch (\Throwable $th) {
                return redirect('emprofile');
            }
        }else{
            return redirect('/');
        }
        
    }

    public function addAttendance()
    {
        session_start();
        if(session('user') != null){
            try {
                if(session('isStart')){
                    DB::table('employees')->where('id',session('id'))->update(['status' => 'Working']);
                    DB::table('attendance')->insert(
                        [
                            'emp_id' => session('id'),
                            'in_time' => now(),
                            'date' => now(),
                            'status' => 'active'
                        ]
                    );
                    session()->put('isStart',false);
                    return redirect('empdashboard');
                }else{
                    $inTime = DB::table('attendance')->where('emp_id', session('id'))
                                                        ->where('date', date("Y-m-d"))->get('in_time');
                    $workhours = (strtotime(date("H:i:s")) - strtotime($inTime[0]->in_time))/60/60;
                    DB::table('attendance')->where('emp_id', session('id'))->update(
                        [
                            'out_time' => now(),
                            'whours' => round($workhours,2),
                            'status' => 'finish'
                        ]
                    );
                    DB::table('employees')->where('id',session('id'))->update(['status' => 'Left']);
                    session()->put('isStart',true);
                    return redirect('empdashboard');
                }
            } catch (\Throwable $th) {
                return redirect('attendance');
            }
            
        }else{
            return redirect('/');
        }

        
    }

    public function attendance()
    {
        session_start();
        if(session('user') != null){
            try {
                $currentUserAttendance = DB::table('attendance')
                                            ->where('emp_id', session('id'))
                                                ->get();
                return view('employee.attendance',
                            [
                                'pic'=>session('pic'),
                                'groub'=>session('groub'),
                                'name'=>session('user'),
                                'attendance'=>$currentUserAttendance
                            ]
                        );
            } catch (\Throwable $th) {
                return redirect('empdashboard');
            }
            
        }else{
            return redirect('/');
        }
    }

    public function getAttendance(Request $request)
    {
        session_start();
        if(session('user') != null){
            try {
                $attendance = DB::table('attendance')
                                ->whereMonth('date', $request->month)
                                    ->whereYear('date', $request->year)
                                        ->get();
                return view('employee.attendance',
                            [
                                'pic'=>session('pic'),
                                'groub'=>session('groub'),
                                'name'=>session('user'),
                                'attendance'=>$attendance
                            ]
                            );
            } catch (\Throwable $th) {
                return redirect('empdashboard');
            }
            
        }else{
            return redirect('/');
        }
    }

    public function applyLeave()
    {
        session_start();
        if(session('user') != null){
            return view('employee.applyleave',[
            'pic'=>session('pic'),
            'groub'=>session('groub'),
            'name'=>session('user')]);
        }else{
            return redirect('/');
        }
    }

    public function addLeave(Request $request)
    {
        session_start();
        if(session('user') != null){
            try {
                $leaves = DB::table('leaving')
                            ->insert(
                                        [
                                            'emp_id' => session('id'),
                                            'comment' => $request->comment,
                                            'type'=> $request->type,
                                            'timefrom'=>$request->from,
                                            'timeto'=>$request->to,
                                            'day'=> date('y/m/d',strtotime(now()))
                                        ]
                                    );
                return redirect('applyleave');
            } catch (\Throwable $th) {
                //throw $th;
                return redirect('applyleave');
            }
            
        }else{
            return redirect('/');
        }
    }

    public function leave()
    {
        session_start();
        if(session('user') != null){
            $leaves = DB::table('leaving')->where('emp_id', session('id'))->get();
            return view('employee.leave',['pic' => session('pic'),'groub'=>session('groub'),'name'=>session('user'),'leaves'=> $leaves]);
        }else{
            return redirect('/');
        }
    }

    public function holiday()
    {
        session_start();
        if(session('user') != null){
            return view('employee.holiday',['pic' => session('pic'),'groub'=>session('groub'),'name'=>session('user')]);
        }else{
           return redirect('/');
        }
    }

    public function profile()
    {
        session_start();
        if(session('user') != null){
            return view('employee.profile',['pic' => session('pic'),'groub'=>session('groub'),'name'=>session('user')]);
        }else{
            return redirect('/');
        }
    }

    public function changePass()
    {
        session_start();
        if(session('user') != null){
            return view('employee.changePass',['pic' => session('pic'),'groub'=>session('groub'),'name'=>session('user')]);
        }else{
            return redirect('/');
        }
    }

    public function changePassword(Request $request)
    {
        session_start();
        if(session('user') != null){
            try {
                $user = DB::table('employees')
                            ->where("name", session('user'))
                                ->get();
                if(password_verify($request->old, $user[0]->pass)){
                    $user = DB::table('employees')
                                    ->where("name", session('user'))
                                        ->update([
                                            'pass' => Hash::make($request->new),
                                        ]);
                    return redirect('empdashboard');
                }else{
                    return redirect('changePassemp');
                }
            } catch (\Throwable $th) {
                return redirect('changePassemp');
            }
            

        }else{
            return redirect('/');
        }
    }

    public function logout()
    {
        session_start();
        if(session('user') != null){
            session()->put('user',null);
            session()->put('id',null);
            session()->put('isStart',true);
            return redirect('/');
        }else{
            return redirect('/');
        }
    }

    public function employeeDetails(Request $request)
    {
        session_start();
        if(session('user') != null){
            $user = DB::table('employees')->where('id', $request->id)->get();
            return view('employee.employeeDetaills',['name'=>session('user'),'pic' => session('pic'),'groub'=>session('groub'),'user'=>$user]);
        }else{
            return redirect('/');
        }
    }

    public function getEmployees()
    {
        session_start();
        if(session('user') != null && session('groub') == 1){
            $user = DB::table('employees')->where('name',session('user'))->get();
            $users = DB::table('employees')->where('depart' ,$user[0]->depart)
                        ->leftJoin("departs", 'employees.depart', '=', 'departs.id')
                            ->select("employees.*", "departs.depname as depname")
                                ->get();
            return view('employee.employees',
                                            [
                                                'pic' => session('pic'),
                                                'groub'=>session('groub'),
                                                'name'=>session('user'),
                                                'users' => $users,
                                            ]);
        }else{
            return redirect('/');
        }
    }

    public function projects(){
        session_start();
        if(session('user') != null && session('groub') == 1){
            $data = DB::table('projects')
                            ->leftJoin('departs', 'projects.depart', '=', 'departs.id')
                                    ->orderBy('projects.id', 'desc')
                                        ->get();
            return view('employee.projects',
                        [
                            'pic' => session('pic'),
                            'groub'=>session('groub'),
                            'name'=>session('user'),
                            'data' => $data,
                        ]);
        }else{
            return redirect('/');
        }
    }

    public function addTaskForm(){
        session_start();
        if(session('user') != null && session('groub') == 1){
            $data = DB::table('employees')
                            ->where('depart', session('depart'))
                                ->select('id','name')
                                    ->orderBy('name', 'asc')
                                        ->get();
            $projects = DB::table('projects')
                        ->where('depart',session('depart'))
                            ->select('id','proname')
                                ->orderBy('id', 'asc')
                                    ->get();
            return view('employee.addTask',
                        [
                            'pic' => session('pic'),
                            'groub'=>session('groub'),
                            'name'=>session('user'),
                            'data' => $data,
                            'proj' => $projects,
                        ]);
        }else{
            return redirect('/');
        }
    }

    public function addTask(Request $request){
        session_start();
        if(session('user') != null && session('groub') == 1){
            $store_path = 'C:\xampp\htdocs\tracking\public\files/';
            $pic_name = $_FILES['descrip']['name'];
            $stor_name  = $request->name. '.'.explode('.',$pic_name)[1];
            $stor_tmp = $_FILES['descrip']['tmp_name'];
            DB::table('tasks')->insert([
                'Name' => $request->name,
                'employee' => $request->employ,
                'project' => $request->project,
                'startline' => $request->start,
                'endline' => $request->end,
                'descriFile' => $stor_name,
            ]);
            move_uploaded_file($stor_tmp, $store_path . str_replace(' ', '', $stor_name));
            return redirect('addtask');
        }else{
            // return redirect('/');
        }
    }

    public function Tasks(){
        session_start();
        if(session('user') != null && session('groub') == 1){
            $data = DB::table('tasks')
                            ->leftJoin('projects', 'tasks.project', '=', 'projects.id')
                                ->leftJoin('employees', 'tasks.employee', '=', 'employees.id')
                                    ->select('tasks.*','projects.proname','employees.name as empname')
                                        ->orderBy('projects.startline', 'desc')
                                            ->orderBy('projects.proname', 'asc')
                                                ->get();
            return view('employee/tasks',
                        [
                            'pic' => session('pic'),
                            'groub'=>session('groub'),
                            'name'=>session('user'),
                            'data' => $data,
                        ]);
        }else{
            return redirect('/');
        }
    }

    public function editTask($id){
        session_start();
        if(session('user') != null && session('groub') == 1){
            $data = DB::table('tasks')->where('id',$id)->get();
            $employees = DB::table('employees')->select('id','name')->get();
            $projects = DB::table('projects')->select('id','proname')->get();
            return view('employee/editTask',
                        [
                            'pic' => session('pic'),
                            'id' => session('id'),
                            'groub'=>session('groub'),
                            'name'=>session('user'),
                            'data' => $data,
                            'employees' => $employees,
                            'projects' => $projects,
                        ]);
        }else{
            return redirect('/');
        }
    }

    public function updateTask(Request $request,$id){
        session_start();
        if(session('user') != null && session('groub') == 1){
            if($request->descrip == null){
                DB::table('tasks')->where('id',$id)->update([
                    'name' => $request->name,
                    'employee' => $request->employ,
                    'project' => $request->project,
                    'startline' => $request->start,
                    'endline' => $request->end,
                    'progress' => $request->progress,
                ]);
                return redirect('tasks');
            }else{
                $store_path = 'C:\xampp\htdocs\tracking\public\files/';
                $pic_name = $_FILES['descrip']['name'];
                $stor_name  = $request->name. '.'.explode('.',$pic_name)[1];
                $stor_tmp = $_FILES['descrip']['tmp_name'];
                $stor_name = str_replace(' ', '', $stor_name);
                DB::table('tasks')->where('id',$id)->update([
                    'name' => $request->name,
                    'employee' => $request->employ,
                    'project' => $request->project,
                    'startline' => $request->start,
                    'endline' => $request->end,
                    'descriFile' => $stor_name,
                ]);
                move_uploaded_file($stor_tmp, $store_path . str_replace(' ', '', $stor_name));
                return redirect('tasks');
            }
        }else{
            return redirect('/');
        }
    }

    public function delTask($id){
        session_start();
        if(session('user') != null && session('groub') == 1){
            DB::table('tasks')->delete($id);
            return redirect('tasks');
        }else{
            return redirect('/');
        }
    }

    public function empTasks(){
        session_start();
        if(session('user') != null ){
            $data = DB::table('tasks')->where('tasks.employee', session('id'))
                                        ->leftJoin('projects','tasks.project', '=', 'projects.id')
                                            ->select('tasks.*','projects.proname')
                                                ->orderBy('tasks.endline', 'desc')
                                                    ->get();
            return view('employee.mytasks',
                        [
                            'pic' => session('pic'),
                            'id' => session('id'),
                            'groub'=>session('groub'),
                            'name'=>session('user'),
                            'data' => $data,
                        ]);
        }else{
            return redirect('/');
        }
    }

    public function updateprogress(Request $request ,$id){
        session_start();
        if(session('user') != null ){
            DB::table('tasks')->where('id',$id)->update(['progress' => $request->progress]);
            return redirect('mytasks');
        }else{
            return redirect('/');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
