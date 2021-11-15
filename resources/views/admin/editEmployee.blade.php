@extends('admin.header')

@section('title', 'edit employee')

@section('content')
@section('subtitle', 'edit employee')

<div class="add-emp">
                    <form action="/updateEmployee/{{$data[0]->id}}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col col-xl-6">
                                <h6>Personal Details</h6>
                                <hr>
                                <label>User Name</label>
                                <div class="input">
                                    <i class="fa fa-user"></i>
                                    <input type="text" name="username" value="{{$data[0]->username}}" required>
                                </div><br>
                                <label>Name</label>
                                <div class="input">
                                    <i class="fa fa-user"></i>
                                    <input type="text" name="name" value="{{$data[0]->name}}" required>
                                </div><br>
                                <label>Birth Date</label>
                                <div class="input">
                                    <input id = 'myDate' type="date" name="date" class="date" value="{{$data[0]->dob}}"  required>
                                </div><br>
                                <label>Gender</label>
                                <select name="gender" class="input"  required>
                                    @if($data[0]->gender == 'male')
                                        <option value="male" selected>Male</option>
                                        <option value="female">Female</option>
                                    @else
                                        <option value="male" >Male</option>
                                        <option value="female" selected>Female</option>
                                    @endif
                                </select><br>
                                <label>Department</label>
                                <!-- <div class="input"> -->
                                    <select name="depart" class="input" require>
                                        @foreach($depart as $dep)
                                            @if($dep->id == $data[0]->depart)
                                                <option value="{{$dep->id}}" selected>{{$dep->depname}}</option>
                                            @else
                                                <option value="{{$dep->id}}">{{$dep->depname}}</option>
                                            @endif
                                        @endforeach
                                    </select><br>
                                <label>Phone</label>
                                <div class="input">
                                    <i class="fa fa-phone"></i>
                                    <input type="number" name="phone" value="{{$data[0]->phone}}" required>
                                </div><br>
                                <label>Address</label>
                                <div class="input">
                                    <i class="fa fa-home"></i>
                                    <input type="text" name="address" value="{{$data[0]->address}}" required>
                                </div><br>
                            </div>
                            <div class="col col-xl-6">
                                <h6>Account Login</h6>
                                <hr>
                                <label>Email</label>
                                <div class="input">
                                    <i class="fa fa-envelope"></i>
                                    <input type="text" name="email" value="{{$data[0]->email}}" required>
                                </div><br>
                                <label>Password</label>
                                <div class="input">
                                    <i class="fa fa-key"></i>
                                    <input type="password" name="pass">
                                </div><br>

                            </div>
                        </div>
                        <div class="center"><button class="save">Save</button></div>
                    </form>
                </div>

@endsection