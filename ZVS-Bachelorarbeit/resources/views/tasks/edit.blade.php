@extends('layouts.app')

@section('header')
	Tätigkeit {{$task->number}} von Projekt {{$project->id}} bearbeiten
@endsection

@section('content')
	{!! Form::open(['action' => ['taskController@update', $project->id,  $task->number], 'method' => 'POST', 'enctype'=> 'multipart/form-data']) !!}
	<div class="form-row col-sm-12">
		<div class="form-group col-sm-3">
			{{Form::label('name', 'Tätigkeitsname')}}
			{{Form::text('name', $task->name,['class' => 'form-control', 'placeholder' => 'Tätigkeitsname'])}}
		</div>
	</div>
	<div class="form-row col-sm-12">
		<div class="form-group col-sm-2">
			{{Form::label('shouldTime', 'Sollzeit')}}
			{{Form::number('shouldTime',  $task->shouldTime,['class' => 'form-control', 'placeholder' => 'Sollzeit'])}}
		</div>
	</div>
	{{Form::hidden('project',$project->id)}}
	{{Form::hidden('number',$task->number)}}
	<div class="form-row col-sm-12">
		<div class="form-group col-sm-2">
			{{Form::hidden('_method', 'PUT')}}
			{{Form::submit('Update', ['class'=>'btn btn-primary'])}}
			<a class="btn btn-danger" href="/project/{{$project->id}}">Abbrechen</a>
		</div>
	</div>
	{!! Form::close() !!}
@endsection