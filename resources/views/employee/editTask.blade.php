@extends('employee.header')

@section('title', 'Add Task')

@section('subtitle', 'Add Task')

@section('content')
            <div class="add-task">
                <form action="/edittask/{{$data[0]->id}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="center">
                        <label>Name</label>
                        <input type="text" class="input" name="name" value="{{$data[0]->Name}}" require><br>
                        <label>Employee</label>
                            <select name="employ" class="input" require>
                                @foreach($employees as $emp)
                                    @if($emp->id == $data[0]->employee)
                                        <option value="{{$emp->id}}" selected>{{ucwords($emp->name)}}</option>
                                    @else
                                        <option value="{{$emp->id}}">{{ucwords($emp->name)}}</option>
                                    @endif
                                @endforeach
                            </select><br>
                        <label>Project</label>
                            <select name="project" class="input" require>
                                @foreach($projects as $pro)
                                    @if($pro->id == $data[0]->employee)
                                        <option value="{{$pro->id}}" selected>{{ucwords($pro->proname)}}</option>
                                    @else
                                        <option value="{{$pro->id}}">{{ucwords($pro->proname)}}</option>
                                    @endif
                                @endforeach
                            </select><br>
                        <label>Start</label>
                            <input type="date" class="input" name="start" value="{{$data[0]->startline}}" require><br>
                        <label>End</label>
                            <input type="date" class="input" name="end" value="{{$data[0]->endline}}" require><br>
                            <label>Progress</label>
                            <input type="number" class="input" name="progress" value="{{$data[0]->progress}}" require><br>
                        <label>Description</label>
                            <div class="file input">
                                <i class="fa fa-file"></i>
                                <span id="src">Select PDF File</span>
                                <input type="file" id="fileImg" name="descrip" accept="application/pdf,application" />
                            </div><br>
                        <div class="hr"></div>
                        <div class="center">
                            <button class="save">Save</button>
                        </div>
                    </div>
                </form>
            </div>
@endsection