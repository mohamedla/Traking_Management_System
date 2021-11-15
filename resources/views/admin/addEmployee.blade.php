@extends('admin.header')

@section('title', 'add employee')

@section('subtitle', 'add employee')

@section('content')

<div class="add-emp">
                    <div class="row">
                        <div class="col col-xl-6">
                            <form action="addemp" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                                <label>User Name</label>
                                <div class="input">
                                    <i class="fa fa-user"></i>
                                    <input type="text" name="username" required>
                                </div><br>
                                <label>Name</label>
                                <div class="input">
                                    <i class="fa fa-user"></i>
                                    <input type="text" name="name" required>
                                </div><br>
                                <label>Picture</label>
                                <div class="file input">
                                    <i class="fa fa-user"></i>
                                    <span id="src">Select Picture</span>
                                    <input type="file" id="fileImg" name="pic">
                                </div><br>
                                <label>department</label>
                                <select name="depart" class="input" require>
                                    <option >Select Depatment</option>
                                    @foreach($data as $dep)
                                    <option value="{{$dep->id}}">{{$dep->depname}}</option>
                                    @endforeach
                                </select><br>
                                <label>Birth Date</label>
                                <div class="input">
                                    <input type="date" name="date" class="date" required>
                                </div><br>
                                <label>Gender</label>
                                <select name="gender" class="input" name="gender">
                                    <option>Select Gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select><br>
                                <label>Phone</label>
                                <div class="input">
                                    <i class="fa fa-phone"></i>
                                    <input type="number" name="phone" required>
                                </div><br>
                                <label>Address</label>
                                <div class="input">
                                    <i class="fa fa-home"></i>
                                    <input type="text" name="address" required>
                                </div><br>
                        </div>
                        <div class="col col-xl-6">
                            <h6>Account Login</h6>
                            <hr>
                            <label>Email</label>
                            <div class="input">
                                <i class="fa fa-envelope"></i>
                                <input type="text" name="email" required>
                            </div><br>
                            <label>Password</label>
                            <div class="input">
                                <i class="fa fa-key"></i>
                                <input type="password" name="pass" required>
                            </div>
                        </div>
                        <div class="center"><button class="save">Save</button></div>
                        </form>
                    </div>
                   
                </div>
               </div>

@endsection