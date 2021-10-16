@extends('admin.header')

@section('title', 'edit department')

@section('content')

@section('subtitle', 'edit department')

<div class="add-depart">
                    <form action="/updateDepart/{{$data[0]->id}}/{{$head}}" method="post">
                        @csrf
                        <div class="center">
                            <label>Department</label>
                            <input type="text" class="input" name="depart" value='{{$data[0]->depname}}' required><br>
                            <label>Head Id</Head></label>
                            <input type="number" class="input" name="headid" value='{{$head}}' required>
                        </div>
                        <hr class="hr">
                        <div class="center"><button class="save">Save</button></div>
                    </form>
                </div>

@endsection