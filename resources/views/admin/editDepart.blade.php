@extends('admin.header')

@section('title', 'Edit Department')

@section('content')

@section('subtitle', 'Edit Department')

<div class="add-depart">
                    <form action="/updateDepart/{{$data[0]->id}}/{{$head}}" method="post">
                        @csrf
                        <div class="center">
                            <label>Department</label>
                            <input type="text" class="input" name="depart" value='{{$data[0]->depname}}' required><br>
                            <label>Head</Head></label>
                            <!-- <input type="number" class="input" name="headid" value='{{$head}}' required> -->
                            <select name="headid" class="input" require>
                                <option value="0">Not Selected Yet</option>
                                @foreach($emps as $emp)
                                    @if($emp->id == $data[0]->head_id)
                                        <option value="{{$emp->id}}" selected>{{$emp->name}}</option>
                                    @else
                                        <option value="{{$emp->id}}">{{$emp->name}}</option>
                                    @endif
                                @endforeach
                            </select><br>
                        </div>
                        <hr class="hr">
                        <div class="center"><button class="save">Save</button></div>
                    </form>
                </div>

@endsection