@extends('layouts.app')

@section('header')
	Daten von Projekt {{$project->id}}
@endsection

@section('content')
	<div class="well">
        <form action="{{ route('project.destroy', $project) }}" method="POST">
            <a class="btn btn-primary" href="/project">Zurück</a>
            <button class="btn btn-warning" type="button" onclick="showProject()">Bearbeiten</button>
            <button class="btn btn-success" type="button" onclick="showCreateTask()">Tätigkeit hinzufügen</button>
            {{ method_field('DELETE') }}
            {{ csrf_field() }}
            <button class="btn btn-danger"> Löschen</button>
        </form>
	</div>

	<div class="panel panel-default">
		<div class="panel-heading">
			Projektdaten
		</div>
		<div class="panel-body">
			<table class="table table-bordered table-striped">
				<tbody>
					<tr>
						<td class="col-sm-2">Projektnummer</td>
						<td>{{$project->id}}</td>
					</tr>
					<tr>
						<td>Name</td>
						<td>{{$project->name}}</td>
					</tr>
					<tr>
						<td>Kunde</td>
						<td>{{$project->client}}</td>
					</tr>
					<tr>
						<td>Sollzeit (Stunden)</td>
						<td>{{$project->shouldTime}}</td>
					</tr>
					<tr>
						<td>Istzeit (Stunden)</td>
						<td>{{$project->isTimeHours()}}</td>
					</tr>
					<tr>
						<td>Freigabedatum</td>
						<td>{{$project->startDate}}</td>
					</tr>
					<tr>
						<td>Frist</td>
						<td>{{$project->endDate}}</td>
					</tr>
					<tr>
						<td></td>
						<td></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<div class="panel panel-default">
		<div class="panel-heading">
			Tätigkeiten
		</div>
		<div class="panel-body">
			<table id="table_id" class="table table-bordered">
				<thead>
				<tr>
					<th>#</th>
					<th>Tätigkeit</th>
					<th>Soll Zeit (Stunden)</th>
					<th>Ist Zeit (Stunden)</th>
					<td></td>
				</tr>
				</thead>
				<tbody>
				@foreach($tasks as $task)
					<tr>
						<td>{{$task->number}}</td>
						<td>{{$task->name}}</td>
						<td>{{$task->shouldTime}}</td>
						<td>{{$task->isTimeHours()}}</td>
						<td>
							<div>
                                {{ Form::open(['method' => 'DELETE', 'route' => ['task.destroy', $task->project, $task->number] ]) }}
								<div class="col-sm-1"></div>
								<a href="/project/{{$project->id}}/task/{{$task->number}}" class="btn btn-primary col-sm-3">Anzeigen</a>
								<div class="col-sm-1"></div>
                                <button class="btn btn-warning col-sm-3" type="button" onclick="showEditTask('{{$task->name}}',{{$task->number}},{{$task->shouldTime}})">Bearbeiten</button>
                                <div class="col-sm-1"></div>
                                <button type="submit" class="btn btn-danger col-sm-3">Löschen</button>
                                {{ Form::close() }}
							</div>
						</td>
					</tr>
				@endforeach
				</tbody>
			</table>
		</div>
	</div>

    <!-- Modal to edit tasks -->
    <div class="modal fade" id="editTaskModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Tätigkeit anlegen</h4>
                </div>
                <div class="modal-body row">
                    <form action="/" method="POST" id="editTaskForm">
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
                        <input type="hidden" name="project" value="{{$project->id}}">

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

    <!-- Modal to create task -->
    <div class="modal fade" id="taskModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Tätigkeit anlegen</h4>
                </div>
                <div class="modal-body row">
                    <form action="{{ route('task.store', $project->id) }}" method="POST" id="taskForm">
                        <div class="form-row col-sm-12">
                            <div class="form-group col-sm-4">
                                {{Form::label('name', 'Tätigkeitsname')}}
                                {{Form::text('name','',['class' => 'form-control', 'placeholder' => 'Tätigkeitsname'])}}
                            </div>
                        </div>
                        <div class="form-row col-sm-12">
                            <div class="form-group col-sm-4">
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
                        {{ csrf_field() }}
                        {{Form::hidden('project',$project->id)}}
                    </form>
                    <div class="align-right">
                        <div class="col-sm-6"></div>
                        <input type="button" class="btn btn-primary align-right" value="Submit" id="submitButton" />
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Abbrechen</button>
                    </div>
                </div>
                <div class="modal-footer">
                </div>
            </div>

        </div>
    </div>

    <!-- Modal to edit the project -->
    <div class="modal fade" id="projectModal" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Tätigkeit anlegen</h4>
                </div>
                <div class="modal-body row">
                    <form action="{{ action('projectController@update', [   'project' => $project->id]) }}" method="POST" id="editProjectForm">
                        <div class="form-row col-sm-12">
                            <div class="form-group col-sm-9">
                                {{Form::label('name', 'Projektname')}}
                                {{Form::text('name', $project->name, ['class' => 'form-control', 'placeholder' => 'Projektname'])}}
                            </div>
                        </div>
                        <div class="form-row col-sm-12">
                            <div class="form-group col-sm-12">
                                {{Form::label('description', 'Beschreibung')}}
                                {{Form::text('description', $project->description, ['class' => 'form-control', 'placeholder' => 'Beschreibung'])}}
                            </div>
                        </div>
                        <div class="form-row col-sm-12">
                            <div class="form-group col-sm-6">
                                {{Form::label('client', 'Kunde')}}
                                {{Form::text('client', $project->client, ['class' => 'form-control', 'placeholder' => 'Kunde'])}}
                            </div>
                        </div>
                        <div class="form-row col-sm-12">
                            <div class="form-group col-sm-6">
                                {{Form::label('startDate', 'Start')}}
                                {{Form::date('startDate', $project->startDate, ['class'=>'form-control','placeholder'=>''])}}
                            </div>
                        </div>
                        <div class="form-row col-sm-12">
                            <div class="form-group col-sm-6">
                                {{Form::label('endDate', 'Frist')}}
                                {{Form::date('endDate', $project->endDate, ['class'=>'form-control','placeholder'=>''])}}
                            </div>
                        </div>
                        {{ csrf_field() }}
                        {{Form::hidden('_method', 'PUT')}}
                        {{Form::hidden('project',$project->id)}}
                    </form>
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-primary" value="Submit" id="editProject" />
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Abbrechen</button>
                </div>
            </div>

        </div>
    </div>

@endsection

@section('scripts')
    
    <script>
        function showCreateTask() {
            $(taskModal).modal('show');
        }
    </script>

    <script>
        function showProject() {
            $(projectModal).modal('show');
        }
    </script>

    <script>
        function showEditTask(name, number, time) {

            var newName = name.toString();

            document.getElementsByClassName("editName")[0].value = newName;
            document.getElementsByClassName("editTime")[0].value = time;
            document.getElementsByClassName("editNumber")[0].value = number;

            $('form').attr('action', '/project/{{$project->id}}/task/'+number);

            $(editTaskModal).modal('show');
        }
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $("#submitButton").click(function() {
                $("#taskForm").submit();
            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $("#submitEditTask").click(function() {
                $("#editTaskForm").submit();
            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $("#editProject").click(function() {
                $("#editProjectForm").submit();
            });
        });
    </script>

@endsection



