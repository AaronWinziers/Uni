@extends('layouts.scanner')

@section('header')
&emsp;Projekt {{$project->id}}
@endsection

@section('content')
    <div class="well col-sm-12">
        <a class="btn btn-primary btn-lg col-sm-2" href="/project">Zurück</a>
    </div>
    <div class="panel-group">
        @foreach($tasks as $task)
            <div class="col-sm-4">
                <div class="panel panel-default">
                    <div class="panel-heading"><h3>Tätigkeit {{$task->number}} - {{$task->name}}</h3></div>
                    <div class="panel-body">
                        <button class="btn btn-primary btn-lg" type="button" onclick="showTransponderModal('{{$task->project}}','{{$task->number}}')">Tätigkeit Beginnen</button>
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
        function showTransponderModal(project, task) {
            document.getElementById('transponderForm').action = "/confirm/"+project+"/"+task+"/";
            $(transponderModal).modal('show');
        }
    </script>
@endsection