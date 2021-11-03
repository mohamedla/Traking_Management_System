@extends('admin.header')

@section('title', 'Add Project')

@section('subtitle', 'Add Project')

@section('content')

                <div class="add-emp">
                    <div class="row">
                        <div class="col col-xl-6 center">
                            <form action="addproject" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                                <label>Name</label>
                                <div class="input">
                                    <i class="fa fa-user"></i>
                                    <input type="text" name="name" require>
                                </div><br>
                                <label>Department</label>
                                <select name="depart" class="input" require>
                                    <option >Select Depatment</option>
                                    @foreach($data as $dep)
                                    <option value="{{$dep->id}}">{{$dep->depname}}</option>
                                    @endforeach
                                </select><br>
                                <label>Start Date</label>
                                <div class="input">
                                    <input type="date" name="startline" class="date" require>
                                </div><br>
                                <label>End Date</label>
                                <div class="input">
                                    <input type="date" name="deadline" class="date" require>
                                </div><br>
                                <label>Description</label>
                                <div class="file input">
                                    <i class="fa fa-file"></i>
                                    <span id="src">Select PDF File</span>
                                    <input type="file" id="fileImg" name="descrip" accept="application/pdf,application"   require/>
                                </div><br>
                                <div class="center">
                                    <button class="save">Save</button>
                                </div>
                        </div>
                        </form>
                    </div>
                   
                </div>
               </div>

@endsection