@extends('employee.header')

@section('title', 'Projects')

@section('subtitle', 'Projects')

@section('content')
<div class="emp">
                    
                    <div class="scroll">
                     <table class="table table-striped">
                         <thead>
                           
                           <tr>
                             <th scope="col">#</th>
                             <th scope="col">Name</th>
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
                             <td>{{$data[$i]->proname}}</td>
                             <td>{{$data[$i]->startline}}</td>
                             <td>{{$data[$i]->endline}}</td>
                             <td><a href="/view/{{$data[$i]->descriFile}}" style="color: black; font-weight:bold"  target="_blank">{{$data[$i]->descriFile}}</a></td>
                             <td><div class='percentage-out'>
                                     <div class="percentage-in" style="width: {{$data[$i]->progress}}%;">{{$data[$i]->progress}}%</div>
                                 </div></td>
                           </tr>
                           @endfor
                           
                         </tbody>
                     </table>
                    </div>
                 </div>
@endsection