@extends('layouts.scanner')

@section('header')
&emsp;Projektenübersicht
@endsection

@section('content')
    <div class="well col-sm-12">
        <a class="btn btn-primary btn-lg col-sm-2" href="/">Meine Daten</a>
    </div>
    <div class="panel-group">
        @foreach($projects as $project)
            <div class="col-sm-4">
                <div class="panel panel-default">
                    <div class="panel-heading"><h3>Projekt {{$project->id}}</h3></div>

                    <div class="panel-body">
                        <h3>{{$project->name}} - {{$project->client}}</h3>
                        <h3>Von: {{$project->startDate}}</h3>
                        <h3>Bis: {{$project->endDate}}</h3>
                        <a href="project/{{$project->id}}" class="btn btn-primary btn-lg">Tätigkeiten Anzeigen</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h2>Heute</h2>
        </div>
        <div class="panel-body">
            <table id="table_id" class="table table-bordered">
                <thead>
                <tr>
                    <th>Projekt</th>
                    <th>Tätigkeit</th>
                    <th>Eingestempelt um</th>
                    <th>Abgestempelt um</th>
                    <th>Länge (Stunden)</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($logs as $log)
                    <tr>
                        <td>{{$log->projectID}}</td>
                        <td>{{$log->taskNum}}</td>
                        <td>{{$log->timeStart}}</td>
                        <td>{{$log->timeEnd}}</td>
                        <td>{{$log->durationHours()}}</td>
                        <td>
                            <div>
                                <div class="col-sm-2"></div>
                                <button type="button" class="btn btn-primary col-sm-4" data-toggle="modal" data-target="#myModal">Gearbeitete Stunden hinzufügen</button>
                                <div class="col-sm-1"></div>
                                <a href="/project/{{$log->projectID}}/task/{{$log->taskNum}}/edit" class="btn btn-warning col-sm-4">Bearbeiten</a>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection