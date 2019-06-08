@extends('layouts.empapp')

@section('header')
	Ihre Daten
@endsection

@section('content')
    <div class="well">
        @if(empty($running))
            <h3>Zur Zeit arbeiten Sie an keinem Projekt</h3>
        @else
            <h3>Sie Arbeiten seit {{date("h:i",strtotime($running->timeStart))}} an Projekt {{$running->projectID}}, Tätigkeit {{$running->taskNum}}</h3>
            <a href="/log/{{auth()->user()->employee}}" class="btn btn-danger">Beenden</a>
        @endif
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
                <tr>
                    <td>Urlaubstage</td>
                    <td>20</td>
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
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection