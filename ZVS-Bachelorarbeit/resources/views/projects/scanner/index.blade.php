@extends('layouts.scanner')

@section('header')
 &emsp;Projektenübersicht
@endsection

@section('content')
    <div class="well col-sm-12">
        <button class="btn btn-primary btn-lg col-sm-2" type="button" onclick="showTransponderModal('employee')">Meine Daten</button>
        <div class="col-sm-1"></div>
        <button class="btn btn-danger btn-lg col-sm-2" type="button" onclick="showTransponderModal('log')">Arbeit Beenden</button>
    </div>
    <div class="panel-group">
    @foreach($projects as $project)
        <div class="col-sm-4">
            <div class="panel panel-default">
                <div class="panel-heading"><h3>Projekt {{$project->id}}</h3></div>

                <div class="panel-body">
                    <h3>{{$project->name}} - {{$project->client}}</h3>
                    <h3>Von: {{$project->startDate}}</h3>
                    <h3>Bis: {{$project->endDate}}</h3>
                    <a href="project/{{$project->id}}" class="btn btn-primary btn-lg">Tätigkeiten Anzeigen</a>
                </div>
            </div>
        </div>
    @endforeach
    </div>

    <!-- Modal -->
    <div id="transponderModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content" id="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times</button>
                    <h2 class="modal-title">Halten sie ihren Transponder gegen den Leser</h2>
                </div>
                <div class="modal-body row col-sm-12">
                    <form action="" onsubmit="myInfo()" id="transponderForm">
                        <div class="form-row col-sm-12">
                            <div class="form-group col-sm-6">
                                {{Form::text('transponder','',['class'=>'form-control','placeholder'=>'', 'id'=>'transponder'])}}
                            </div>
                            <button id="infoButton" class="btn btn-success col-sm-3" type="button" onclick="myInfo()">Submit</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer"></div>

            </div>

        </div>
    </div>


@endsection

@section('scripts')

    <!-- Go to MyInfo page -->
    <script>
        function myInfo() {
            var tNum = document.getElementById("transponder").value;
            var act = document.getElementById('transponderForm').action;
            document.getElementById('transponderForm').action = act+tNum;
        }
    </script>

    <script>
        $('#transponderModal').on('shown.bs.modal', function () {
            $("#transponder").focus();
        });
    </script>

    <!-- Show myInfo modal -->
    <script>
        function showTransponderModal(page) {
            document.getElementById('transponderForm').action = "/"+page+"/";
            $(transponderModal).modal('show');
        }
    </script>


@endsection