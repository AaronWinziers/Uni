@extends('layouts.app')

@section('header')
    Kundenübersicht: {{$client->name}}
@endsection

@section('content')
    <div class="well">
        <a class="btn btn-primary" href="/client">Zurück</a>
    </div>

    <div class="panel panel-default">
        <div class="panel-body">
            <table id="table_id" class="display table-bordered">
                <thead>
                <tr>
                    <th>Nummer</th>
                    <th>Name</th>
                    <th>Kunde</th>
                    <th>Beschreibung</th>
                    <th/>
                </tr>
                </thead>
                <tbody>

                @foreach($projects as $project)
                    <tr>
                        <td>{{$project->id}}</td>
                        <td>{{$project->name}}</td>
                        <td>{{$project->client}}</td>
                        <td>{{$project->description}}</td>
                        <td>
                            <div>
                                <div class="col-sm-2"></div>
                                <a href="/project/{{$project->id}}" class="btn btn-primary col-sm-4">Übersicht</a>
                                <div class="col-sm-1"></div>
                                <a href="/project/{{$project->id}}/edit" class="btn btn-warning col-sm-4">Bearbeiten</a>
                            </div>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            Kunde ändern
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
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection