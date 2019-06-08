@extends('layouts.app')

@section('header')
    Log ändern
@endsection

@section('content')
<div class="panel-body">
    {!! Form::open(['action' => ['logController@store'], 'method' => 'POST', 'enctype'=> 'multipart/form-data']) !!}
    <div class="form-row col-sm-12">
        <div class="form-group col-sm-2">
            {{Form::label('employeeID', 'Mitarbeiternummer')}}
            {{Form::text('employeeID','',['class' => 'form-control', 'placeholder' => $log->employeeID])}}
        </div>
    </div>
    <div class="form-row col-sm-12">
        <div class="form-group col-sm-2">
            {{Form::label('timeStart', 'Eingestempelt')}}
            {{Form::datetimelocal('timeStart','',['class' => 'form-control', 'placeholder' => $log->timeStart])}}
        </div>
    </div>
    <div class="form-row col-sm-12">
        <div class="form-group col-sm-2">
            {{Form::label('timeEnd', 'Ausgestempelt')}}
            {{Form::datetimelocal('timeEnd','',['class' => 'form-control', 'placeholder' => $log->timeEnd])}}
        </div>
    </div>
    <div class="form-row col-sm-12">
        <div class="form-group col-sm-2">
            {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
            <a class="btn btn-danger" href="/project/{{$log->projectID}}/task/{{$log->taskNum}}">Abbrechen</a>
        </div>
    </div>
    {{Form::hidden('projectID',$log->projectID)}}
    {{Form::hidden('taskNum',$log->taskNum)}}
    {!! Form::close() !!}
</div>
@endsection