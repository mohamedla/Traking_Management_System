@extends('employee.header')

@section('title', 'Employees')

@section('subtitle', 'Employees')

@section('content')
                 <div class="content">
                 <div class="scroll">
                    <table class="table table-striped">
                        <thead>
                          <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Department</th>
                            <th scope="col">Address</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $u)
                            <tr>
                                <th scope="row">
                                    @if($u->groubID == 1)
                                    <i class="fa fa-user" style="color: blue;"></i>
                                    {{$u->name}}
                                    @elseif($u->groubID == 2)
                                    <i class="fa fa-user" style="color: green;"></i>
                                    {{$u->name}}
                                    @else
                                    {{$u->name}}
                                    @endif
                                </th>
                                <td>{{$u->email}}</td>
                                <td>{{$u->depname}}</td>
                                <td>{{$u->address}}</td>
                                <td>{{$u->phone}}</td>
                                <td><form action="empdetail" method="post">
                                    @csrf
                                    <input type="hidden" id="custId" name="id" value="{{$u->id}}">
                                    <button class="details" style="color: white; background-color: green">
                                    <i class="fa fa-eye" style="color: black;"></i>&nbsp;view details
                                 </button></form></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                   </div>
                 </div>
                </div>
               </div>
           </div>
        </div>
@endsection