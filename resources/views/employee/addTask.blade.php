@extends('employee.header')

@section('title', 'Add Task')

@section('subtitle', 'Add Task')

@section('content')
                <div class="add-task">
                    <div class="add-leave">
                    <form action="addtask" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="center">
                            <label>Name</label>
                            <input type="text" class="input" name="name" require><br>
                            <label>Employee</label>
                                <select name="employ" class="input" require>
                                    <option >Select Employee</option>
                                    @foreach($data as $emp)
                                    <option value="{{$emp->id}}">{{$emp->name}}</option>
                                    @endforeach
                                </select><br>
                            <label>Project</label>
                                <select name="project" class="input" require>
                                    <option >Select Project</option>
                                    @foreach($proj as $pro)
                                    <option value="{{$pro->id}}">{{$pro->proname}}</option>
                                    @endforeach
                                </select><br>
                            <label>Start</label>
                                <input type="date" class="input" name="start" require><br>
                            <label>End</label>
                                <input type="date" class="input" name="end" require><br>
                            <label>Description</label>
                                <div class="file input">
                                    <i class="fa fa-file"></i>
                                    <span id="src">Select PDF File</span>
                                    <input type="file" id="fileImg" name="descrip" accept="application/pdf,application"   require/>
                            </div><br>
                        </div>
                        <div class="hr"></div>
                        <div class="center">
                            <button class="save">Save</button>
                        </div>
                    </form>
                </div>
               </div>
@endsection