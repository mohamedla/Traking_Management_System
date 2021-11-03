@extends('admin.header')

@section('title', 'manage employee')

@section('content')

@section('subtitle', 'manage employee')

<div class="manage-emp">
                    <!--<h5>Manage Employee</h5>
                    <hr>-->
                    <!-- <span class="show">
                        <label>show</label>
                        <input type="number" min="1" max="100" class="input">
                        <label>entries</label>
                    </span> -->
                    <form action="searchemp" method="POST" enctype="multipart/form-data">
                    @csrf
                        <span class="show">
                          <label>search</label>
                          <input type="text" name="search" required>
                          <button class="save">Search</button>
                        </span>
                    </form>
                    <!-- <br> -->
                   <div class="scroll">
                    <table class="table table-striped">
                        <thead>
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Department</th>
                            <th scope="col">address</th>
                            <th scope="col">Status</th>
                            <th scope="col">Actions</th>
                          </tr>
                        </thead>
                        <tbody>
                          @for($i=0; $i< count($data) ; $i++)
                          <tr>
                            <th scope="row">{{$i+1}}</th>
                            <td>
                                {{$data[$i]->name}}</td>
                            <td>{{$data[$i]->email}}</td>
                            <td>{{$data[$i]->depname}}</td>
                            <td>{{$data[$i]->address}}</td>
                            <td>
                            @if($data[$i]->status == "Working")
                              <button class="status" disabled style='background: rgb(5, 151, 5);' >
                                    <i class="fa fa-check-square-o"></i>
                            @else
                              <button class="status" disabled style='background: rgb(5, 20, 5);width:90%'>
                            @endif
                                    {{ucwords($data[$i]->status)}}
                              </button>  

                            </td>
                            <th>
                                <button class="details">
                                    <i class="fa fa-eye"></i>
            <a href="/employeeDetails/{{$data[$i]->id}}" style="color: white;">view details</a>
                                 </button>
                                 <button class="edit">
                                     <i class="fa fa-edit"></i>
        <a href="/editEmployee/{{$data[$i]->id}}/" style="color: white;">Edit</a>
                                 </button>
                                 <button class="delete">
                                     <i class="fa fa-close"></i>
                    <a href="/deleteEmployee/{{$data[$i]->id}}" style="color: white;">delete</a>
                                 </button>
                            </th>
                          </tr>
                          <tr>
                            @endfor
                             
                        </tbody>
                    </table>
                   </div>
                </div>

@endsection