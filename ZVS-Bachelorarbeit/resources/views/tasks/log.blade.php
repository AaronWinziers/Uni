@extends('layouts.app')

@section('header')
    Neue Tätigkeit für Projekt {{$project->id}} anlegen
@endsection

@section('content')
    {!! Form::open(['action' => ['logController@store', $project->id, $task->number], 'method' => 'POST', 'enctype'=> 'multipart/form-data']) !!}
    <div class="form-row col-sm-12">
        <div class="form-row col-sm-12">
            <div class="form-group col-sm-2">
                {{Form::label('employeeID', 'Mitarbeiter')}}
                {{Form::select('employeeID',$employees,['class' => 'form-control', 'placeholder' => ''])}}
            </div>
        </div>
        <div class="form-group col-sm-3">
            {{Form::label('timeStart', 'Eingestempelt')}}
            {{Form::datetimelocal('timeStart','',['class' => 'form-control', 'placeholder' => ''])}}
        </div>
        <div class="form-group col-sm-3">
            {{Form::label('timeEnd', 'Ausgestempelt')}}
            {{Form::datetimelocal('timeEnd','',['class' => 'form-control', 'placeholder' => ''])}}
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
@endsection