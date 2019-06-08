@extends('layouts.empapp')

@section('header')
    Wilkommen Employee
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Meine Daten
                </div>
                <div class="panel-body">
                    <a href="/employee" class="btn btn-primary">Übersicht</a>
                    <a href="/employee/create" class="btn btn-primary">Neu Anlegen</a>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Projekte
                </div>
                <div class="panel-body">
                    <a href="/project" class="btn btn-primary">Übersicht</a>
                    <a href="/project/create" class="btn btn-primary">Neu Anlegen</a>
                </div>
            </div>
        </div>
    </div>

@endsection