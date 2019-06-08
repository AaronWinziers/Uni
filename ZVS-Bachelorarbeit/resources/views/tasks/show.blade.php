@extends('layouts.app')

@section('header')
    Daten Tätigkeit {{$task->number}} von Projekt {{$project->id}}
@endsection

@section('content')
    <div class="well">
        <a class="btn btn-primary" href="/project/{{$project->id}}">Zurück</a>
        <a class="btn btn-warning" href="/project/{{$project->id}}/task/{{$task->number}}/edit">Bearbeiten</a>
        <!--<a class="btn btn-warning" href="/project/{{$project->id}}/task/{{$task->number}}/log/create">Arbeitszeit hinzufügen</a>-->
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            Daten
        </div>
        <div class="panel-body">
            <table class="table table-bordered table-striped">
                <tbody>
                <tr>
                    <td>Nummer</td>
                    <td>{{$task->number}}</td>
                </tr>
                <tr>
                    <td>Name</td>
                    <td>{{$task->name}}</td>
                </tr>
                <tr>
                    <td>Projekt</td>
                    <td>{{$project->id}} // {{$project->name}}</td>
                </tr>
                <tr>
                    <td>Sollzeit</td>
                    <td>{{$task->shouldTime}}</td>
                </tr>
                <tr>
                    <td>IstZeit</td>
                    <td>{{$task->isTimeHours()}}</td>
                </tr>
                </tbody>
            </table>
        </div>
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
                    <th>Abgestempelt um</th>
                    <th>Länge (Stunden)</th>
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
                        <td>{{$log->timeEnd}}</td>
                        <td>{{$log->durationHours()}}</td>
                        <td>
                            <div class="col-sm-12">
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
    <div class="panel panel-default">
        <div class="panel-heading">
            Arbeitsperiode Eintragen
        </div>
        <div class="panel-body">
            {!! Form::open(['route' => 'log.store', 'method' => 'PUT', 'enctype'=> 'multipart/form-data']) !!}
            <div class="form-row col-sm-12">
                <div class="form-group col-sm-2">
                    {{Form::label('employeeID', 'Mitarbeiternummer')}}
                    {{Form::text('employeeID','',['class' => 'form-control', 'placeholder' => ''])}}
                </div>
            </div>
            <div class="form-row col-sm-12">
                <div class="form-group col-sm-2">
                    {{Form::label('timeStart', 'Eingestempelt')}}
                    {{Form::datetimelocal('timeStart','',['class' => 'form-control', 'placeholder' => ''])}}
                </div>
            </div>
            <div class="form-row col-sm-12">
                <div class="form-group col-sm-2">
                    {{Form::label('timeEnd', 'Ausgestempelt')}}
                    {{Form::datetimelocal('timeEnd','',['class' => 'form-control', 'placeholder' => null])}}
                </div>
            </div>
            <div class="form-row col-sm-12">
                <div class="form-group col-sm-2">
                    {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
                    <a class="btn btn-danger" href="/project/{{$project->id}}/task/{{$task->number}}">Abbrechen</a>
                </div>
            </div>
            {{Form::hidden('projectID',$project->id)}}
            {{Form::hidden('taskNum',$task->number)}}
            {!! Form::close() !!}
        </div>
    </div>

    <!-- Modal to edit tasks -->
    <div class="modal fade" id="editTaskModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Tätigkeit anlegen</h4>
                </div>
                <div class="modal-body">
                    <form action="/" method="POST" id="editTaskForm">
                        <div class="form-row col-sm-12">
                            <div class="form-group col-sm-3">
                                {{Form::label('name', 'Tätigkeitsname')}}
                                {{Form::text('name', null,['class' => 'form-control, editName', 'placeholder' => 'Tätigkeitsname'])}}
                            </div>
                        </div>
                        <div class="form-row col-sm-12">
                            <div class="form-group col-sm-2">
                                {{Form::label('shouldTime', 'Sollzeit')}}
                                {{Form::number('shouldTime',  null,['class' => 'form-control, editTime', 'placeholder' => 'Sollzeit'])}}
                            </div>
                        </div>
                        <input type="hidden" name="number" class="editNumber" value="{{null}}">
                        <input type="hidden" name="project" value="{{$project->id}}">

                        {{ csrf_field() }}
                        {{Form::hidden('_method', 'PUT')}}
                    </form>
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-primary" value="Submit" id="submitEditTask" />
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Abbrechen</button>
                </div>
            </div>

        </div>
    </div>

@endsection