@extends('layouts.app')

@section('header')
	Neuen Mitarbeiter anlegen
@endsection

@section('content')
	{!! Form::open(['action' => 'employeeController@store', 'method' => 'POST', 'enctype'=> 'multipart/form-data']) !!}
		<div class="form-row col-sm-12">
			<div class="form-group col-sm-6">
				{{Form::label('lastName', 'Name')}}
				{{Form::text('lastName','',['class' => 'form-control', 'placeholder' => 'Name'])}}
			</div>
		</div>
		<div class="form-row col-sm-12">
			<div class="form-group col-sm-6">
				{{Form::label('firstName', 'Vorname')}}
				{{Form::text('firstName','',['class' => 'form-control', 'placeholder' => 'Vorname'])}}
			</div>
		</div>
		<div class="form-row col-sm-12">
			<div class="form-group col-sm-6">
				{{Form::label('id', 'Mitarbeiter Nummer')}}
				{{Form::number('id','',['class' => 'form-control', 'placeholder' => ''])}}
			</div>
		</div>
		<div class="form-row col-sm-12">
			<div class="form-group col-sm-6">
				{{Form::label('department', 'Abteilung')}}
				{{Form::text('department','',['class' => 'form-control', 'placeholder' => 'Abteilung'])}}
			</div>
		</div>
		<div class="form-row col-sm-12">
			<div class="form-group col-sm-6">
				{{Form::label('hours', 'Wochenstunden')}}
				{{Form::text('hours','',['class'=>'form-control','placeholder'=>'0'])}}
			</div>
		</div>
	<div class="form-row col-sm-12">
		<div class="form-group col-sm-2">
			{{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
			<a class="btn btn-danger" href="/employee">Abbrechen</a>
		</div>
	</div>

	{!! Form::close() !!}
@endsection