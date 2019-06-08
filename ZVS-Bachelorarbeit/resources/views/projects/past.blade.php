@extends('layouts.app')

@section('header')
    Vergangene Projekte
@endsection

@section('content')
    <div class="well">
        <a class="btn btn-primary" href="/project">Zurück</a>
        <!--<a class="btn btn-info" href="/project/all">Alle Projekte</a>-->
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
                <td>{{$project->endDate}}</td>
                <td>
                    <div class="col-sm-3"></div>
                    <a href="/project/{{$project->id}}" class="btn btn-primary fa fa-eye col-sm-6"> Übersicht</a>
            </tr>
        @endforeach
        </tbody>
    </table>



    <!-- Modal to edit the project -->
    <div class="modal fade" id="editModal" role="dialog">
        <div class="modal-dialog    ">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Tätigkeit anlegen</h4>
                </div>
                <div class="modal-body">
                    <form action="{{ action('projectController@update', ['project' => $project->id]) }}" method="POST" id="editForm">
                        <div class="form-row col-sm-12">
                            <div class="form-group col-sm-9">
                                {{Form::label('name', 'Projektname')}}
                                {{Form::text('name', $project->name, ['class' => 'form-control, name', 'placeholder' => 'Projektname'])}}
                            </div>
                        </div>
                        <div class="form-row col-sm-12">
                            <div class="form-group col-sm-12">
                                {{Form::label('description', 'Beschreibung')}}
                                {{Form::text('description', $project->description, ['class' => 'form-control, description', 'placeholder' => 'Beschreibung'])}}
                            </div>
                        </div>
                        <div class="form-row col-sm-12">
                            <div class="form-group col-sm-6">
                                {{Form::label('client', 'Kunde')}}
                                {{Form::text('client', $project->client, ['class' => 'form-control, client', 'placeholder' => 'Kunde'])}}
                            </div>
                        </div>
                        <div class="form-row col-sm-12">
                            <div class="form-group col-sm-6">
                                {{Form::label('startDate', 'Start')}}
                                {{Form::date('startDate', $project->startDate, ['class'=>'form-control, startDate','placeholder'=>''])}}
                            </div>
                        </div>
                        <div class="form-row col-sm-12">
                            <div class="form-group col-sm-6">
                                {{Form::label('endDate', 'Frist')}}
                                {{Form::date('endDate', $project->endDate, ['class'=>'form-control, endDate','placeholder'=>''])}}
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

    <!-- Submit Edit Form -->
    <script type="text/javascript">
        $(document).ready(function() {
            $("#editProject").click(function() {
                $("#editForm").submit();
            });
        });
    </script>

    <script>
        function showEdit(name, id, description, client, startDate, endDate) {

            var newName = name.toString();

            document.getElementsByClassName("name")[0].value = newName;
            document.getElementsByClassName("id")[0].value = id;
            document.getElementsByClassName("description")[0].value = description;
            document.getElementsByClassName("client")[0].value = client;
            document.getElementsByClassName("startDate")[0].value = startDate;
            document.getElementsByClassName("endDate")[0].value = endDate;

            $('editForm').attr('action', '/project/'+id+"/edit");


            $(editModal).modal('show');
        }
    </script>


@endsection