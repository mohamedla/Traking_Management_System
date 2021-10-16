@extends('admin.header')

@section('title', 'manage quite')

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
                            <th scope="col">Quite</th>
                            <th scope="col">Person</th>
                            <th scope="col">Actions</th>
                          </tr>
                        </thead>
                        <tbody>
                          
                          @for($i=0; $i< count($data) ; $i++)
                          <tr>
                            <th scope="row"> {{$i+1}} </th>
                            <td>{{$data[$i]->quote}}</td>
                            <td>{{$data[$i]->person}}</td>
                            <td>
                                 <button class="edit">
                                     <i class="fa fa-edit"></i>
                              <a href="/editQuote/{{$data[$i]->id}}/{{$data[$i]->quote}}/{{$data[$i]->person}}">Edit</a>
                                 </button>
                                 <button class="delete">
                                     <i class="fa fa-close"></i>
                              <a href="/deleteQuote/{{$data[$i]->id}}">Delete</a> </button>
                                 </button>
                            </td>
                          </tr>
                          @endfor
                          
                          
                        </tbody>
                    </table>
                   </div>
                </div>

@endsection