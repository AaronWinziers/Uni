@extends('layouts.app')

@section('header')
	Wilkommen
@endsection

@section('content')
	<div class="row">
		<div class="col-sm-4">
			<div class="panel panel-default">
				<div class="panel-heading">
					Mitarbeiter
				</div>
				<div class="panel-body">
					<a href="/employee" class="btn btn-primary">Übersicht</a>
				</div>
			</div>
		</div>
		<div class="col-sm-4">
			<div class="panel panel-default">
				<div class="panel-heading">
					Projekte
				</div>
				<div class="panel-body">
					<a href="/project" class="btn btn-primary">Übersicht</a>
				</div>
			</div>
		</div>
		<div class="col-sm-4">
			<div class="panel panel-default">
				<div class="panel-heading">
					Kunden
				</div>
				<div class="panel-body">
					<a href="/client" class="btn btn-primary">Übersicht</a>
				</div>
			</div>
		</div>

	</div>

@endsection