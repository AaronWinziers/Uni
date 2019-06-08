@extends('layouts.app')

@section('header')
    Wilkommen Scanner
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Mitarbeiter
                </div>
                <div class="panel-body">
                    <a href="/employee" class="btn btn-primary">Mitarbeiter</a>
                    <a href="/employee/create"><h3>Neu Anlegen</h3></a>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h5>Mitarbeiter</h5>
                </div>
                <div class="panel-body">
                    <h5 class="panel-title">Special title treatment</h5>
                    <p class="panel-text">With supporting text below as a natural lead-in to additional content.</p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h5>Mitarbeiter</h5>
                </div>
                <div class="panel-body">
                    <h5 class="panel-title">Special title treatment</h5>
                    <p class="panel-text">With supporting text below as a natural lead-in to additional content.</p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h5>Mitarbeiter</h5>
                </div>
                <div class="panel-body">
                    <h5 class="panel-title">Special title treatment</h5>
                    <p class="panel-text">With supporting text below as a natural lead-in to additional content.</p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
        </div>
    </div>

@endsection