@extends('admin.header')

@section('title', 'Manage Departs')

@section('content')
@section('subtitle', 'Manage Departs')

<div class="emp">
                    
                   <div class="scroll">
                    <table class="table table-striped">
                        <thead>
                          
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">Department</th>
                            <th scope="col">Head Name</th>
                            <th scope="col">Total Employees</th>
                            <th scope="col">Actions</th>
                          </tr>

                          
                        </thead>
                        <tbody>
                          @for($i=0; $i< count($data) ; $i++)
                          
                          <tr>
                            <th scope="row">{{$i+1}}</th>
                            <td>{{$data[$i]->depname}}</td>
                            @if($data[$i]->head_id == 0)
                              <td>Not Assigned</td>
                            @else
                              <td>{{$data[$i]->empname}}</td>
                            @endif
                            <td>{{$data[$i]->totemp}}</td>
                            <td>
                                 <button class="edit">
                                     <i class="fa fa-edit"></i>
                            <a href="/editDepart/{{$data[$i]->id}}/" style="color: white">Edit</a>
                                 </button>
                                 <button class="delete">
                                     <i class="fa fa-close"></i>
                            <a href="/deleteDepart/{{$data[$i]->id}}" style="color: white">Delete</a> </button>
                                 </button>
                            </td>
                          </tr>
                          @endfor
                          
                        </tbody>
                    </table>
                   </div>
                </div>

@endsection