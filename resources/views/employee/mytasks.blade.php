@extends('employee.header')

@section('title', 'Projects')

@section('subtitle', 'Projects')

@section('content')
<div class="emp">
                    
                    <div class="scroll">
                     <table class="table table-striped" >
                         <thead>
                           
                           <tr>
                             <th scope="col">#</th>
                             <th scope="col">Name</th>
                             <th scope="col">Project</th>
                             <th scope="col">Start Date</th>
                             <th scope="col">End Date</th>
                             <th scope="col">Description File</th>
                             <th scope="col">Progress</th>
                           </tr>
 
                           
                         </thead>
                         <tbody>
                           @for($i=0; $i< count($data) ; $i++)
                           
                           <tr>
                             <th scope="row">{{$i+1}}</th>
                             <td>{{$data[0]->Name}}</td>
                             <td>{{$data[0]->proname}}</td>
                             <td>{{date('d-m-Y',strtotime($data[0]->startline))}}</td>
                             <td>{{date('d-m-Y',strtotime($data[0]->endline))}}</td>
                             <td><a href="/view/{{$data[$i]->descriFile}}" style="color: black; font-weight:bold;"  target="_blank">{{$data[$i]->descriFile}}</a></td>
                             <td>
                                <button class="open-button" onclick="openForm()">
                                    <div class='percentage-out'>
                                        <div class="percentage-in" style="width: {{$data[$i]->progress}}%;">{{$data[$i]->progress}}%</div>
                                    </div>
                                </button>
                                <div class="form-popup" id="progress">
                                    <form action="/updateprogress/{{$data[$i]->id}}" class="form-container" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <h5><label for="email"><b>Progress</b></label></h5>
                                        <input type="number" placeholder="{{$data[$i]->progress}}" name="progress" required>

                                        <button type="submit" class="btn">Change</button>
                                        <button type="button" class="btn cancel" onclick="closeForm()">Close</button>
                                    </form>
                                </div>
                            </td>
                           </tr>
                           @endfor
                           
                         </tbody>
                     </table>
                    </div>
                 </div>

                                
@endsection