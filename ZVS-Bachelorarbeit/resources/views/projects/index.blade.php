@extends('layouts.app')

@section('header')
	Aktuelle Projekte
@endsection

@section('content')
	<div class="well">
		<a class="btn btn-primary" href="/">Zurück</a>
        <a class="btn btn-info" href="/project/past">Vergangene Projekte</a>
        <!--<a class="btn btn-info" href="/project/all">Alle Projekte</a>-->
        <!--<a class="btn btn-warning" href="/project/create">Projekt erstellen</a>!-->
        <button class="btn btn-warning" type="button" onclick="$(createModal).modal('show')">Projekt erstellen</button>
	</div>
	<table id="table_id" class="display table-bordered">
		<thead>
			<tr>
				<th>Nummer</th>
				<th>Name</th>
				<th>Kunde</th>
				<th>Anfang</th>
				<th>Ende</th>
				<th/>
			</tr>
		</thead>
		<tbody>

			@foreach($projects as $project)
				<tr>
					<td>{{$project->id}}</td>
					<td>{{$project->name}}</td>
					<td>{{$project->client}}</td>
					<td>{{$project->startDate}}</td>
					<td>{{$project->endDate}}<td>
						<div>
							<a href="/project/{{$project->id}}" class="btn btn-primary fa fa-eye col-sm-3"> Übersicht</a>
                            <div class="col-sm-1"></div>
                            <button class="btn btn-warning fa fa-edit col-sm-3" type="button" onclick=
                                    "showEdit('{{$project->name}}','{{$project->id}}','{{$project->description}}','{{$project->client}}','{{$project->startDate}}','{{$project->endDate}}')"
                                    >Bearbeiten</button>
                            <div class="col-sm-1"></div>
                            <a href="/project/{{$project->id}}/deactivate" class="btn btn-danger fa fa-exclamation-triangle col-sm-3"> Beenden</a>
						</div>
				</tr>
			@endforeach
		</tbody>
	</table>

    <!-- Modal to create project -->
    <div class="modal fade" id="createModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Projekt anlegen</h4>
                </div>
                <div class="modal-body row col-sm-12">
                    <form action="{{ route('project.store') }}" method="POST" id="createForm">
                        {{ csrf_field() }}
                        <div class="form-row col-sm-12">
                            <div class="form-group col-sm-9">
                                {{Form::label('name', 'Projektname')}}
                                {{Form::text('name','',['class' => 'form-control', 'placeholder' => 'Projektname'])}}
                            </div>
                            <div class="form-group col-sm-9">
                                {{Form::label('id', 'Projektnummer')}}
                                {{Form::text('id','',['class' => 'form-control', 'placeholder' => 'Nummer'])}}
                            </div>
                        </div>
                        <div class="form-row col-sm-12">
                            <div class="form-group col-sm-12">
                                {{Form::label('description', 'Beschreibung')}}
                                {{Form::text('description','',['class' => 'form-control', 'placeholder' => 'Beschreibung'])}}
                            </div>
                        </div>
                        <div class="form-row col-sm-12">
                            <div class="form-group col-sm-10">
                                @include('inc.clientdropdown')
                            </div>
                            <div class="form-group col-sm-5">
                                {{Form::label('startDate', 'Start')}}
                                {{Form::date('startDate','',['class'=>'form-control','placeholder'=>''])}}
                            </div>
                            <div class="form-group col-sm-5">
                                {{Form::label('endDate', 'Frist')}}
                                {{Form::date('endDate','',['class'=>'form-control','placeholder'=>''])}}
                            </div>
                        </div>

                        <div id="tasks" class="form-row col-sm-12">
                            <h4 class="form-row">
                                <b>Tätigkeiten</b>
                                <button class="btn btn-success glyphicon glyphicon-plus" type="button" onclick="addTask()"></button>
                            </h4>
                            <div class="form-row">
                                <div class="form-group col-sm-8">
                                    <label for="name">Tätigkeitsname</label>
                                    <input class="form-control" placeholder="Tätigkeitsname" name="names[]" type="text" value="" id="names" data-emoji_font="true" style="font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;, Symbola, EmojiSymbols !important;">
                                </div>
                                <div class="form-group col-sm-3">
                                    <label for="shouldTime">Sollzeit</label>
                                    <input class="form-control" placeholder="Sollzeit" name="shouldTimes[]" type="number" value="" id="shouldTimes">
                                </div>
                                <div class="form-group col-sm-1">
                                    <label> </label>
                                    <button class="btn btn-danger glyphicon glyphicon-trash" type="button" onclick="removeTask(this)"></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-primary" value="Submit" id="createButton" />
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Abbrechen</button>
                </div>
            </div>

        </div>
    </div>

    <!-- Modal to edit the project -->
    <div class="modal fade" id="editModal" role="dialog">
        <div class="modal-dialog    ">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Tätigkeit anlegen</h4>
                </div>
                <div class="modal-body row">
                    <form action="{{ action('projectController@update', ['project' => $project->id]) }}" method="POST" id="editForm">
                        <div class="form-row col-sm-12">
                            <div class="form-group col-sm-9">
                                {{Form::label('name', 'Projektname')}}
                                {{Form::text('name', $project->name, ['class' => 'form-control name', 'placeholder' => 'Projektname'])}}
                            </div>
                        </div>
                        <div class="form-row col-sm-12">
                            <div class="form-group col-sm-12">
                                {{Form::label('description', 'Beschreibung')}}
                                {{Form::text('description', $project->description, ['class' => 'form-control description', 'placeholder' => 'Beschreibung'])}}
                            </div>
                        </div>
                        <div class="form-row col-sm-12">
                            <div class="form-group col-sm-10">
                                @include('inc.clientdropdown')
                            </div>
                            <div class="form-group col-sm-5">
                                {{Form::label('startDate', 'Start')}}
                                {{Form::date('startDate','',['class'=>'form-control startDate','placeholder'=>''])}}
                            </div>
                            <div class="form-group col-sm-5">
                                {{Form::label('endDate', 'Frist')}}
                                {{Form::date('endDate','',['class'=>'form-control endDate','placeholder'=>''])}}
                            </div>
                        </div>
                        {{ csrf_field() }}
                        {{Form::hidden('_method', 'PUT')}}
                        {{Form::hidden('id',null,['class'=>'id'])}}
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
    <!-- Add task to form -->
    <script type="text/javascript">
        function addTask(button) {
            var html = '<div class="form-row">\n' +
                '                                <div class="form-group col-sm-8">\n' +
                '                                    <label for="name">Tätigkeitsname</label>\n' +
                '                                    <input class="form-control" placeholder="Tätigkeitsname" name="names[]" type="text" value="" id="names" data-emoji_font="true" style="font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;, Symbola, EmojiSymbols !important;">\n' +
                '                                </div>\n' +
                '                                <div class="form-group col-sm-3">\n' +
                '                                    <label for="shouldTime">Sollzeit</label>\n' +
                '                                    <input class="form-control" placeholder="Sollzeit" name="shouldTimes[]" type="number" value="" id="shouldTimes">\n' +
                '                                </div>\n' +
                '                                <div class="form-group col-sm-1">\n' +
                '                                    <label> </label>\n' +
                '                                    <button class="btn btn-danger glyphicon glyphicon-trash" type="button" onclick="removeTask(this)"></button>\n' +
                '                                </div>\n' +
                '                            </div>';
            $(tasks).append(html);
        };
    </script>

    <!-- Remove task from form -->
    <script type="text/javascript">
        function removeTask(element) {
            var del = $(element).parent().parent();
            $(del).remove();

        };
    </script>


    <!-- Submit Create Form -->
    <script type="text/javascript">
        $(document).ready(function() {
            $("#createButton").click(function() {
                $("#createForm").submit();
            });
        });
    </script>

    <!-- Submit Edit Form -->
    <script type="text/javascript">
        $(document).ready(function() {
            $("#editProject").click(function() {
                $("#editForm").submit();
            });
        });
    </script>

    <!-- Show Edit Form -->
    <script>
        function showEdit(name, id, description, client, startDate, endDate) {

            var newName = name.toString();

            document.getElementsByClassName("name")[0].value = newName;
            document.getElementsByClassName("id")[0].value = id;
            document.getElementsByClassName("description")[0].value = description;
            document.getElementsByClassName("client")[1].value = client;
            document.getElementsByClassName("startDate")[0].value = startDate;
            document.getElementsByClassName("endDate")[0].value = endDate;


            document.getElementById('editForm').action = '/project/'+id;

            $(editModal).modal('show');
        }
    </script>


@endsection