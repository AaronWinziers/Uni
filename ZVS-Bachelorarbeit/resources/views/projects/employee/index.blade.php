@extends('layouts.empapp')

@section('header')
    Projektenübersicht
@endsection

@section('content')
    <style>
        h3 {
        display:inline;
        }
    </style>
    <div class="well">
        @if(empty($running))
            <h3>Zur Zeit arbeiten Sie an keinem Projekt</h3>
        @else
            <h3>Sie Arbeiten seit {{date("h:i",strtotime($running->timeStart))}} an Projekt {{$running->projectID}}, Tätigkeit {{$running->taskNum}}</h3>
            <a href="/log/{{auth()->user()->employee}}" class="btn btn-danger">Beenden</a>
        @endif
    </div>
    <table id="table_id" class="display table-bordered">
        <thead>
        <tr>
            <th>Nummer</th>
            <th>Name</th>
            <th>Kunde</th>
            <th>Beschreibung</th>
            <th/>
        </tr>
        </thead>
        <tbody>

        @foreach($projects as $project)
            <tr>
                <td>{{$project->id}}</td>
                <td>{{$project->name}}</td>
                <td>{{$project->client}}</td>
                <td>{{$project->description}}</td>
                <td>
                    <div>
                        <a href="/project/{{$project->id}}" class="btn btn-primary col-sm-12">Übersicht</a>
                    </div>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection