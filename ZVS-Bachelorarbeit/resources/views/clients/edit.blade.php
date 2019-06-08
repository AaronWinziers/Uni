@extends('layouts.app')

@section('header')
    Kunde {{$client->id}}
@endsection

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            Kunde editieren
        </div>
        <div class="panel-body">
            {!! Form::open(['action' => 'Resources\clientController@store', 'method' => 'POST', 'enctype'=> 'multipart/form-data']) !!}
            <div class="form-row col-sm-12">
                <div class="form-group col-sm-6">
                    {{Form::label('id', 'Kundennummer')}}
                    {{Form::text('id', $client->id, ['class' => 'form-control', 'placeholder' => ''])}}
                </div>
            </div>
            <div class="form-row col-sm-12">
                <div class="form-group col-sm-6">
                    {{Form::label('name', 'Name')}}
                    {{Form::text('name', $client->name, ['class' => 'form-control', 'placeholder' => 'Name'])}}
                </div>
            </div>
            <div class="form-row col-sm-12">
                <div class="form-group col-sm-2">
                    {{Form::hidden('_method', 'PUT')}}
                    {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
                    <a class="btn btn-danger" href="/client">Abbrechen</a>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection