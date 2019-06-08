@extends('layouts.scanner')

@section('header')
    <div class="text-center">
        {{$employee->firstName}} {{$employee->lastName}}, wollen sie Projekt {{$task->project}}, Tätigkeit {{$task->number}} beginnen?
    </div>
@endsection

@section('content')
    <div class="well col-sm-12">
        {{ Form::open(['method' => 'PUT', 'route' => 'log.store' ]) }}
        {{Form::hidden('employeeID',$employee->id)}}
        {{Form::hidden('projectID',$task->project)}}
        {{Form::hidden('taskNum',$task->number)}}
        {{Form::hidden('timeStart',\Carbon\Carbon::now())}}
        <div class="col-sm-2"></div>
        <button type="submit" class="btn btn-success btn-lg col-sm-3">Ja</button>
        <div class="col-sm-2"></div>
        <a class="btn btn-danger btn-lg col-sm-3" href="/project/{{$task->projectID}}">Nein</a>
        {{ Form::close() }}
    </div>

@endsection