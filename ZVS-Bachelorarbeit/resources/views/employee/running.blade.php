@extends('layouts.app')

@section('header')
    Aktuelle Arbeit
@endsection

@section('content')
    <div class="well">
        <a class="btn btn-primary" href="/">Zurück</a>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            Tätigkeiten
        </div>
        <div class="panel-body">
            <table id="table_id" class="table table-bordered">
                <thead>
                <tr>
                    <th>Mitarbeiter</th>
                    <th>Projekt</th>
                    <th>Tätigkeit</th>
                    <th>Eingestempelt um</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($logs as $log)
                    <tr>
                        <td>{{$employees[$log->employeeID]["firstName"]}} {{$employees[$log->employeeID]["lastName"]}}</td>
                        <td>{{$log->projectID}}</td>
                        <td>{{$log->taskNum}}</td>
                        <td>{{$log->timeStart}}</td>
                        <td>
                            <a href="/log/{{$log->employeeID}}" class="btn btn-danger">Beenden</a>
                            <div class="col-sm-5">
                                {{ Form::open(['method' => 'DELETE', 'route' => 'log.destroy' ]) }}
                                {{Form::hidden('eid',$log->employeeID)}}
                                {{Form::hidden('pid',$log->projectID)}}
                                {{Form::hidden('tid',$log->taskNum)}}
                                {{Form::hidden('ts',$log->timeStart)}}
                                <button type="submit" class="btn btn-danger col-sm-9">Löschen</button>
                                {{ Form::close() }}
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection