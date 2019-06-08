@extends('layouts.app')

@section('header')
	Neues Projekt anlegen
@endsection

@section('content')
	{!! Form::open(['action' => 'projectController@store', 'method' => 'POST', 'enctype'=> 'multipart/form-data']) !!}
	<div class="form-row col-sm-12">
		<div class="form-group col-sm-3">
			{{Form::label('name', 'Projektname')}}
			{{Form::text('name','',['class' => 'form-control', 'placeholder' => 'Projektname'])}}
		</div>
		<div class="form-group col-sm-3">
			{{Form::label('id', 'Projektnummer')}}
			{{Form::text('id','',['class' => 'form-control', 'placeholder' => 'Nummer'])}}
		</div>
	</div>
	<div class="form-row col-sm-12">
		<div class="form-group col-sm-6">
			{{Form::label('description', 'Beschreibung')}}
			{{Form::text('description','',['class' => 'form-control', 'placeholder' => 'Beschreibung'])}}
		</div>
	</div>
	<div class="form-row col-sm-12">
		<div class="form-group col-sm-2">
			{{Form::label('client', 'Kunde')}}
			{{Form::text('client','',['class' => 'form-control', 'placeholder' => 'Kunde'])}}
		</div>
		<div class="form-group col-sm-2">
			{{Form::label('startDate', 'Start')}}
			{{Form::date('startDate','',['class'=>'form-control','placeholder'=>''])}}
		</div>
		<div class="form-group col-sm-2">
			{{Form::label('endDate', 'Frist')}}
			{{Form::date('endDate','',['class'=>'form-control','placeholder'=>''])}}
		</div>
	</div>
	<div class="form-row col-sm-12">
		<div class="form-group col-sm-2">
			{{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
			<a class="btn btn-danger" href="/project">Abbrechen</a>
		</div>
	</div>
	{!! Form::close() !!}
@endsection