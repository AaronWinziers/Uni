@extends('layouts.app')

@section('header')
    Kundenübersicht
@endsection

@section('content')
    <div class="well">
        <a class="btn btn-primary" href="/">Zurück</a>
    </div>
    <div class="panel panel-default">
        <div class="panel-body">
            <table id="table_id" class="display table-bordered">
                <thead>
                <tr>
                    <th class="col-sm-1">Kundennummer</th>
                    <th>Name</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($clients as $client)
                    <tr>
                        <td>{{$client->id}}</td>
                        <td>{{$client->name}}</td>
                        <td>
                            <div>
                                {{ Form::open(['method' => 'DELETE', 'route' => ['client.destroy', $client, 1] ]) }}
                                <a href="/client/{{$client->id}}" class="btn btn-primary fa fa-eye col-sm-3"> Übersicht</a>
                                <div class="col-sm-1"></div>
                                <a href="/client/{{$client->id}}/edit" class="btn btn-warning fa fa-edit col-sm-3"> Bearbeiten</a>
                                <div class="col-sm-1"></div>
                                <button type="submit" class="btn btn-danger col-sm-3">Löschen</button>
                                {{ Form::close() }}
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            Kunde anlegen
        </div>
        <div class="panel-body">
            {!! Form::open(['action' => 'Resources\clientController@store', 'method' => 'POST', 'enctype'=> 'multipart/form-data']) !!}
            <div class="form-row col-sm-12">
                <div class="form-group col-sm-6">
                    {{Form::label('id', 'Kundennummer')}}
                    {{Form::text('id','',['class' => 'form-control', 'placeholder' => ''])}}
                </div>
            </div>
            <div class="form-row col-sm-12">
                <div class="form-group col-sm-6">
                    {{Form::label('name', 'Name')}}
                    {{Form::text('name','',['class' => 'form-control', 'placeholder' => 'Name'])}}
                </div>
            </div>
            <div class="form-row col-sm-12">
                {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection