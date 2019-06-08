@extends('layouts.app')

@section('header')
	Mitarbeiter {{$employee->id}} bearbeiten
@endsection

@section('content')
	{!! Form::open(['action' => ['employeeController@update', $employee->id], 'method' => 'POST', 'enctype'=> 'multipart/form-data']) !!}
	<div class="form-row col-sm-12">
		<div class="form-group col-sm-6">
			{{Form::label('lastName', 'Name')}}
			{{Form::text('lastName', $employee->lastName, ['class' => 'form-control', 'placeholder' => 'Name'])}}
		</div>
	</div>
	<div class="form-row col-sm-12">
		<div class="form-group col-sm-6">
			{{Form::label('firstName', 'Vorname')}}
			{{Form::text('firstName', $employee->firstName, ['class' => 'form-control', 'placeholder' => 'Vorname'])}}
		</div>
	</div>
	<div class="form-row col-sm-12">
		<div class="form-group col-sm-6">
			{{Form::label('department', 'Abteilung')}}
			{{Form::text('department', $employee->department, ['class' => 'form-control', 'placeholder' => 'Abteilung'])}}
		</div>
	</div>
	<div class="form-row col-sm-12">
		<div class="form-group col-sm-2">
			{{Form::label('hours', 'Wochenstunden')}}
			{{Form::text('hours', $employee->hours, ['class'=>'form-control','placeholder'=>'0'])}}
		</div>

	</div>
	<div class="form-row col-sm-12">
		<div class="form-group col-sm-2">
			{{Form::hidden('_method', 'PUT')}}
			{{Form::submit('Update', ['class'=>'btn btn-primary'])}}
			<a class="btn btn-danger" href="/employee/{{$employee->id}}">Abbrechen</a>
		</div>
	</div>
	{!! Form::close() !!}
@endsection