@extends('layouts.app')

@section('header')
	Neue Tätigkeit für Projekt {{$project->id}} anlegen
@endsection

@section('content')
	{!! Form::open(['action' => ['taskController@store', $project->id], 'method' => 'POST', 'enctype'=> 'multipart/form-data']) !!}
	<div class="form-row col-sm-12">
		<div class="form-group col-sm-3">
			{{Form::label('name', 'Tätigkeitsname')}}
			{{Form::text('name','',['class' => 'form-control', 'placeholder' => 'Tätigkeitsname'])}}
		</div>
		<div class="form-group col-sm-3">
			{{Form::label('number', 'Nummer')}}
			{{Form::text('number','',['class' => 'form-control', 'placeholder' => 'Nummer'])}}
		</div>
	</div>
	<div class="form-row col-sm-12">
		<div class="form-group col-sm-2">
			{{Form::label('shouldTime', 'Sollzeit')}}
			{{Form::number('shouldTime','',['class' => 'form-control', 'placeholder' => 'Sollzeit'])}}
		</div>
	</div>
	<div class="form-row col-sm-12">
		<div class="form-group col-sm-2">
			{{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
			<a class="btn btn-danger" href="/project/{{$project->id}}">Abbrechen</a>
		</div>
	</div>
	{{Form::hidden('project',$project->id)}}
	{!! Form::close() !!}
@endsection