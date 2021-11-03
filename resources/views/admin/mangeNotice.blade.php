@extends('admin.header')

@section('title', 'manage notice')

@section('content')

<div class="emp">
                   
                    <span class="show">
                        <label>show</label>
                        <input type="number" min="1" max="100" class="input">
                        <label>entries</label>
                    </span>
                    <span class="search">
                       <label>search</label>
                       <input type="text" min="1" max="100" class="input">
                   </span><br><br>
                   <div class="scroll">
                    <table class="table table-striped">
                        <thead>
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">Title</th>
                            <th scope="col">Description</th>
                            <th scope="col">Actions</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($data as $note)
                          <tr>
                            <th scope="row">{{$note->id}}</th>
                            <td>{{$note->title}}</td>
                            <td>{{$note->description}}</td>
                            <td>
                                 <button class="edit">
                                     <i class="fa fa-edit"></i>
          <a href="/editNotice/{{$note->id}}/{{$note->title}}/{{$note->description}}">Edit</a>
                                 </button>
                                 <button class="delete">
                                     <i class="fa fa-close"></i>
                                     
          <a href="/deleteNotice/{{$note->id}}">Delete</a> </button>
                            </td>
                          </tr>
                          @endforeach
                          
                        </tbody>
                    </table>
                   </div>
                </div>

@endsection