@extends('layouts.empapp')

@section('header')
    Daten von Projekt {{$project->id}}
@endsection

@section('content')
    <div class="well">
        <a class="btn btn-primary" href="/project">Zurück</a>
    <!--    <a class="btn btn-warning" href="/project/{{$project->id}}/edit">Bearbeiten</a>-->
    <!-- <a class="btn btn-warning" href="/project/{{$project->id}}/task/create">Tätigkeit hinzufügen</a> -->
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
                    <th>Ist Zeit (Stunden)</th>
                    <td></td>
                </tr>
                </thead>
                <tbody>
                @foreach($tasks as $task)
                    <tr>
                        <td>{{$task->number}}</td>
                        <td>{{$task->name}}</td>
                        <td>{{$task->isTimeHours()}}</td>
                        <td>
                            <div>
                                <div class="col-sm-2"></div>
                                <button type="button" class="btn btn-success col-sm-8" data-toggle="modal" data-target='#modal{{$task->number}}'>Tätigkeit Beginnen</button>

                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @foreach($tasks as $task)
    <!-- Modal -->
    <div id="modal{{$task->number}}" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Modal Header</h4>
                </div>
                <div class="modal-body">
                    <p>Wollen sie Projekt {{$task->project}}, Tätigkeit {{$task->number}} beginnen?</p>
                </div>
                <div class="modal-footer">
                    {{ Form::open(['method' => 'PUT', 'route' => 'log.store' ]) }}
                    {{Form::hidden('employeeID',auth()->user()->employee)}}
                    {{Form::hidden('projectID',$task->project)}}
                    {{Form::hidden('taskNum',$task->number)}}
                    {{Form::hidden('timeStart',\Carbon\Carbon::now())}}
                    <button type="submit" class="btn btn-success">Beginnen</button>
                    <div class="col-sm-1"></div>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Abbrechen</button>
                    {{ Form::close() }}
                </div>
            </div>

        </div>
    </div>
    @endforeach

@endsection