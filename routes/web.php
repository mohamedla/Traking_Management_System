<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\SystemEntry;


//**********start of admin routes**************//
Route::view('/login', 'admin/login');
Route::get('/', [AdminController::class,'index']);
Route::get('/register', function(){
    return redirect('/');
});
Route::get('view/{fileName}',[SystemEntry::class,'pdfViewer']);
// Chat section urls
Route::get('chat',[SystemEntry::class,'chat']);
Route::post('searchchatuser',[SystemEntry::class,'searchchatuser']);
Route::get('userdata',[SystemEntry::class,'userdata']);
Route::post('chatdata',[SystemEntry::class,'chatdata']);
Route::post('checkchanges',[SystemEntry::class,'checkchanges']);
Route::post('sendmsg',[SystemEntry::class,'sendmsg']);
Route::get('disconnected',[SystemEntry::class,'disconnected']);
Route::get('reconnected',[SystemEntry::class,'reconnected']);
Route::post('sendfile',[SystemEntry::class,'sendfile']);
Route::post('sendimg',[SystemEntry::class,'sendimg']);
Route::post('sendvideo',[SystemEntry::class,'sendvideo']);
Route::post('sendaudio',[SystemEntry::class,'sendaudio']);
// End 

Route::post('login', [SystemEntry::class,'login']);
Route::get('logout', [SystemEntry::class,'logout']);

Route::post('changePass', [AdminController::class,'changePass']);

Route::post('searchemp', [AdminController::class,'searchemp']);

Route::post('addemp', [AdminController::class,'addemployee']);
Route::any("dashboard" ,  [AdminController::class,'dashData']);
Route::any("manageEmployee" ,  [AdminController::class,'empManage']);

Route::Get("addDep" , [AdminController::class,'addDepart']);
Route::post('addnote', [AdminController::class,'addNotice']);

Route::any("manageDeparts" ,  [AdminController::class,'departManage']);

Route::post('addQ', [AdminController::class,'addQuote']);

Route::view("activityLog" , 'admin/activityLog');

Route::view("addDepart" , 'admin/addDepart');

// Route::view("addEmployee" ,  'admin/addEmployee');
Route::get('addEmployee', [AdminController::class,'addEmpformat']);


Route::view("addHoliday" , 'admin/addHoliday');

Route::view("addLeave" , 'admin/addLeave');
Route::POST("addLeaveReq" , [AdminController::class,'addLeave']);

Route::view("addNotice" , 'admin/addNotice');

Route::view("addQuite" , 'admin/addQuite');

Route::view("changePass" , 'admin/changePass');

Route::any("dailyAttendance" ,[AdminController::class,'dailyAttendAll']);
Route::POST("dailyAttend" ,[AdminController::class,'dailyAttend']);



Route::any("editDepart/{id}" , [AdminController::class,'editDepart']);
Route::post("updateDepart/{id}/{lhead}" , [AdminController::class,'updateDepart']);

Route::any("editEmployee/{id}" , [AdminController::class,'editEmployee']);
Route::POST("updateEmployee/{id}" , [AdminController::class,'updateEmployee']);

Route::any("editNotice/{id}/{title}/{description}" , [AdminController::class,'editNotice']);
Route::POST("updateNotice/{id}" , [AdminController::class,'updateNotice']);

Route::any("editLeave/{id}/{name}/{type}/{timefrom}/{timeto}/{status}/{comment}" , [AdminController::class,'editLeave']);
Route::POST("updateLeave/{id}" , [AdminController::class,'updateLeave']);

Route::any("editQuote/{id}/{quote}/{person}" ,  [AdminController::class,'editQuote']);
Route::POST("updateQuote/{id}" , [AdminController::class,'updateQuote']);


Route::view("employeeDetails" , 'admin/employeeDetaills');

Route::view("leaveType" , 'admin/leaveType');

//Route::view("manageDeparts" , 'admin/manageDeparts');

//Route::view("manageEmployee" , 'admin/manageEmployee');

Route::view("manageHoliday" , 'admin/manageHoliday');

Route::any("manageLeave" , [AdminController::class,'LeavingManage']);

Route::any("manageNotice" , [AdminController::class,'noticeManage']);

Route::any("manageQuite" , [AdminController::class,'QManage']);

Route::view("profile" , 'admin/profile');

Route::view("header" , 'admin/header');

Route::get("deleteQuote/{id}" , [AdminController::class,'deleteQuote']);
Route::get("deleteDepart/{id}" , [AdminController::class,'deleteDepart']);
Route::get("deleteEmployee/{id}" , [AdminController::class,'deleteEmp']);
Route::get("deleteNotice/{id}" , [AdminController::class,'deleteNote']);
Route::any("employeeDetails/{id}" , [AdminController::class,'empDetails']);

    //Projects
Route::get('addproject',[AdminController::class,'addProjectForm']);
Route::post('addproject',[AdminController::class,'addProject']);
Route::get('manageproject',[AdminController::class,'manageProject']);
Route::get('editProject/{id}',[AdminController::class,'editProject']);
Route::post('updateProject/{id}',[AdminController::class,'updateProject']);
Route::get('delProject/{id}',[AdminController::class,'delProject']);
    //end project urls

//*********end of admin routes****************//

//********* start of employee routes**********//
// Route::view("applyleave" , 'employee/applyleave');
// Route::view("attendance" , 'employee/attendance');
// Route::view("changePassemp" , 'employee/changePass');
// Route::view("empdashboard" , 'employee/dashboard');
// Route::view("emprofile" , 'employee/profile');
// Route::view("leave" , 'employee/leave');
// Route::view("Holiday" , 'employee/Holiday');

Route::get('changePassemp', [EmployeeController::class, 'changePass']);
Route::get('emprofile', [EmployeeController::class, 'profile']);
Route::get('attendance', [EmployeeController::class, 'attendance']);
Route::post('attendance', [EmployeeController::class, 'getAttendance']);
Route::post('changePassemp', [EmployeeController::class, 'changePassword']);
Route::get('empdashboard', [EmployeeController::class, 'index']);
Route::get('addattendance', [EmployeeController::class, 'addAttendance']);
Route::get('applyleave', [EmployeeController::class, 'applyLeave']);
Route::post('applyleave', [EmployeeController::class, 'addLeave']);
Route::get('leave', [EmployeeController::class, 'leave']);
Route::get('holiday', [EmployeeController::class, 'holiday']);
Route::post('update',[EmployeeController::class,'updateUser']);
Route::get('emplogout', [EmployeeController::class, 'logout']);
Route::get('empdep', [EmployeeController::class, 'getEmployees']);
Route::post('empdetail', [EmployeeController::class, 'employeeDetails']);
Route::get('projects', [EmployeeController::class, 'projects']);
Route::get('addtask', [EmployeeController::class, 'addTaskForm']);
Route::post('addtask', [EmployeeController::class, 'addTask']);
Route::get('tasks', [EmployeeController::class, 'tasks']);
Route::get('edittask/{id}', [EmployeeController::class, 'editTask']);
Route::post('edittask/{id}', [EmployeeController::class, 'updateTask']);
Route::get('removetask/{id}', [EmployeeController::class, 'delTask']);
Route::get('mytasks', [EmployeeController::class, 'empTasks']);
Route::post('updateprogress/{id}', [EmployeeController::class, 'updateprogress']);



//test page
// Route::view('test', 'test/test');
Route::get('test', [AdminController::class, 'test']);
