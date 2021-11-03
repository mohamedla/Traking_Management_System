@extends('admin.header')

@section('title', 'Edit Project')

@section('content')
@section('subtitle', 'Edit Project')

<div class="add-emp">
                    <form action="/updateProject/{{$data[0]->id}}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col col-xl-6 center">
                                <label>Name</label>
                                <div class="input">
                                    <i class="fa fa-user"></i>
                                    <input type="text" name="name" value="{{$data[0]->proname}}" required>
                                </div><br>
                                <label>Department</label>
                                    <select name="depart" class="input" require>
                                        @foreach($dep as $dep)
                                            @if($dep->id == $data[0]->depart)
                                                <option value="{{$dep->id}}" selected>{{$dep->depname}}</option>
                                            @else
                                                <option value="{{$dep->id}}">{{$dep->depname}}</option>
                                            @endif
                                        @endforeach
                                    </select><br>
                                <label>Start Date</label>
                                <div class="input">
                                    <input id = 'myDate' type="date" name="start" class="date" value="{{$data[0]->startline}}"  required>
                                </div><br>
                                <label>End Date</label>
                                <div class="input">
                                    <input id = 'myDate' type="date" name="end" class="date" value="{{$data[0]->endline}}"  required>
                                </div><br>
                                <label>Description</label>
                                <div class="file input">
                                    <i class="fa fa-file"></i>
                                    <span id="src">Select PDF File</span>
                                    <input type="file" id="fileImg" name="descrip" accept="application/pdf,application" />
                                </div><br>
                                <div class="center"><button class="save">Save</button></div>
                            </div>
                            </div>
                        </div>
                    </form>
                </div>

@endsection