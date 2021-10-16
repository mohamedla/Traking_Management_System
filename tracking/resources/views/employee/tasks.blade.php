@extends('employee.header')

@section('title', 'Projects')

@section('subtitle', 'Projects')

@section('content')
<div class="emp">
                    
                    <div class="scroll">
                     <table class="table table-striped" >
                         <thead>
                           
                           <tr>
                             <th scope="col">#</th>
                             <th scope="col">Name</th>
                             <th scope="col">Project</th>
                             <th scope="col">Start Date</th>
                             <th scope="col">End Date</th>
                             <th scope="col">Employee</th>
                             <th scope="col">Description File</th>
                             <th scope="col">Progress</th>
                             <th scope="col">Actions</th>
                           </tr>
 
                           
                         </thead>
                         <tbody>
                           @for($i=0; $i< count($data) ; $i++)
                           
                           <tr>
                             <th scope="row">{{$i+1}}</th>
                             <td>{{$data[0]->Name}}</td>
                             <td>{{$data[0]->proname}}</td>
                             <td>{{date('d-m-Y',strtotime($data[0]->startline))}}</td>
                             <td>{{date('d-m-Y',strtotime($data[0]->endline))}}</td>
                             <td>{{ucwords($data[0]->empname)}}</td>
                             <td><a href="/view/{{$data[$i]->descriFile}}" style="color: black; font-weight:bold;"  target="_blank">{{$data[$i]->descriFile}}</a></td>
                             <td>
                                 <div class='percentage-out'>
                                     <div class="percentage-in" style="width: {{$data[$i]->progress}}%;">{{$data[$i]->progress}}%</div>
                                 </div>
                            </td>
                            <td>
                                 <button class="edit" >
                                     <i class="fa fa-edit"></i>
                            <a href="/edittask/{{$data[$i]->id}}" style="color: white;">Edit</a>
                                 </button>
                                 <button class="delete">
                                     <i class="fa fa-close"></i>
                            <a href="/removetask/{{$data[$i]->id}}" style="color: white">Delete</a> </button>
                                 </button>
                            </td>
                           </tr>
                           @endfor
                           
                         </tbody>
                     </table>
                    </div>
                 </div>
@endsection