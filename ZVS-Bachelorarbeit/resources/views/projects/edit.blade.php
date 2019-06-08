@extends('layouts.app')

@section('header')
	Projekt {{$project->id}} bearbeiten
@endsection

@section('content')
	{!! Form::open(['action' => ['projectController@update', $project->id], 'method' => 'PUT', 'enctype'=> 'multipart/form-data']) !!}
	<div class="form-row col-sm-12">
		<div class="form-group col-sm-3">
			{{Form::label('name', 'Projektname')}}
			{{Form::text('name', $project->name, ['class' => 'form-control', 'placeholder' => 'Projektname'])}}
		</div>
	</div>
	<div class="form-row col-sm-12">
		<div class="form-group col-sm-5">
			{{Form::label('description', 'Beschreibung')}}
			{{Form::text('description', $project->description, ['class' => 'form-control', 'placeholder' => 'Beschreibung'])}}
		</div>
	</div>
	<div class="form-row col-sm-12">
		<div class="form-group col-sm-1">
			{{Form::label('shouldTime', 'Sollzeit')}}
			{{Form::number('shouldTime', $project->shouldTime, ['class' => 'form-control', 'placeholder' => 'Sollzeit'])}}
		</div>
	</div>
	<div class="form-row col-sm-12">
		<div class="form-group col-sm-2">
			{{Form::label('client', 'Kunde')}}
			{{Form::text('client', $project->client, ['class' => 'form-control', 'placeholder' => 'Kunde'])}}
		</div>
	</div>
	<div class="form-row col-sm-12">
		<div class="form-group col-sm-2">
			{{Form::label('startDate', 'Start')}}
			{{Form::date('startDate', $project->startDate, ['class'=>'form-control','placeholder'=>''])}}
		</div>
	</div>
	<div class="form-row col-sm-12">
		<div class="form-group col-sm-2">
			{{Form::label('endDate', 'Frist')}}
			{{Form::date('endDate', $project->endDate, ['class'=>'form-control','placeholder'=>''])}}
		</div>
	</div>
	<div class="form-row col-sm-12">
		<div class="form-group col-sm-2">
			{{Form::hidden('_method', 'PUT')}}
			{{Form::submit('Update', ['class'=>'btn btn-primary'])}}
			<a class="btn btn-danger" href="/project/{{$project->id}}">Abbrechen</a>
		</div>
	</div>
	{!! Form::close() !!}
@endsection