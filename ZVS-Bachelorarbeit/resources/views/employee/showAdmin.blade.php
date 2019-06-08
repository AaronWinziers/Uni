@extends('layouts.app')

@section('header')
	Daten von {{$employee->lastName}}, {{$employee->firstName}}
@endsection

@section('content')
	<div class="well    ">
        <form action="{{ route('employee.destroy', $employee) }}" method="POST">
            @if($employee->deleted_at == null)
                <a class="btn btn-primary" href="/employee">Zurück</a>
                <a class="btn btn-warning" href="/employee/{{$employee->id}}/edit">Bearbeiten</a>
                <a href="/employee/{{$employee->id}}/deactivate" class="btn btn-danger"> Deaktivieren</a>
            @else
                <a class="btn btn-primary" href="/employee/deactivated">Zurück</a>
                <a class="btn btn-warning" href="/employee/{{$employee->id}}/edit">Bearbeiten</a>
                <a href="/employee/{{$employee->id}}/activate" class="btn btn-success"> Aktivieren</a>
            @endif
            {{ method_field('DELETE') }}
            {{ csrf_field() }}
            <button class="btn btn-danger"> Löschen</button>
        </form>
    </div>

	<div class="card-deck">
		<div class="card col-6">

			<table class="table table-bordered table-striped">
				<thead class="head-light">
				<tr>
					<td class="col-sm-1"></td>
					<td class="col-sm-2 text-center"><b>Persönliche Daten</b></td>
				</tr>
				</thead>
				<tbody>
				<tr>
					<td>Name</td>
					<td>{{$employee->lastName}}</td>
				</tr>
				<tr>
					<td>Vorname</td>
					<td>{{$employee->firstName}}</td>
				</tr>
				<tr>
					<td>Mitarbeiter Nummer</td>
					<td>{{$employee->id}}</td>
				</tr>
				</tbody>
			</table>
		</div>
		<div class="card col-6">

			<table class="table table-bordered table-striped">
				<thead class="head-light">
                    <tr>
                        <td class="col-sm-1"></td>
                        <td class="col-sm-2 text-center"><b>Verwaltungsdaten</b></td>
                    </tr>
				</thead>
				<tbody>
                    <tr>
                        <td>Abteilung</td>
                        <td>{{$employee->department}}</td>
                    </tr>
                    <tr>
                        <td>Wochenstunden</td>
                        <td>{{$employee->hours}}</td>
                    </tr>
				</tbody>
			</table>
		</div>
	</div>
	<div class="panel panel-default">
		<div class="panel-heading">
			Leistungen
		</div>
		<div class="panel-body">
			<table id="table_id" class="table table-bordered">
				<thead>
				<tr>
					<th>Projekt</th>
					<th>Tätigkeit</th>
					<th>Eingestempelt um</th>
					<th>Abgestempelt um</th>
					<th>Länge (Stunden)</th>
					<th></th>
				</tr>
				</thead>
				<tbody>
				@foreach($logs as $log)
					<tr>
						<td>{{$log->projectID}}</td>
						<td>{{$log->taskNum}}</td>
						<td>{{$log->timeStart}}</td>
						<td>{{$log->timeEnd}}</td>
						<td>{{$log->durationHours()}}</td>
						<td>
							<div>
                                <div class="col-sm-2"></div>
                                <button type="button" class="btn btn-danger col-sm-8" data-toggle="modal" data-target="#myModal">Löschen</button>
                            </div>
						</td>
					</tr>
				@endforeach
				</tbody>
			</table>
		</div>
	</div>

    <!-- Modal to edit logs -->
    <div class="modal fade" id="editTaskModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Tätigkeit anlegen</h4>
                </div>
                <div class="modal-body">
                    <form action="/" method="POST" id="editTaskForm">
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

                        <div class="form-row col-sm-12">
                            <div class="form-group col-sm-3">
                                {{Form::label('name', 'Tätigkeitsname')}}
                                {{Form::text('name', null,['class' => 'form-control, editName', 'placeholder' => 'Tätigkeitsname'])}}
                            </div>
                        </div>
                        <div class="form-row col-sm-12">
                            <div class="form-group col-sm-2">
                                {{Form::label('shouldTime', 'Sollzeit')}}
                                {{Form::number('shouldTime',  null,['class' => 'form-control, editTime', 'placeholder' => 'Sollzeit'])}}
                            </div>
                        </div>
                        <input type="hidden" name="number" class="editNumber" value="{{null}}">
                        <input type="hidden" name="project" value="{{$log->projectID}}">

                        {{ csrf_field() }}
                        {{Form::hidden('_method', 'PUT')}}
                    </form>
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-primary" value="Submit" id="submitEditTask" />
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Abbrechen</button>
                </div>
            </div>

        </div>
    </div>


@endsection