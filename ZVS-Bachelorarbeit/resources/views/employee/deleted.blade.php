@extends('layouts.app')

@section('header')
    Deaktivierte Mitarbeiter
@endsection

@section('content')
    <div class="well">
        <a class="btn btn-primary" href="/employee">Zurück</a>
    </div>
    <div class="panel">
        <div class="panel-body">
            <table id="table_id" class="display table-bordered">
                <thead>
                <tr>
                    <th>Mitarbeiter Nummer</th>
                    <th>Name</th>
                    <th>Vorname</th>
                    <th>Abteilung</th>
                    <th>Nutzername</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($employees as $employee)
                    <tr>
                        <td>{{$employee->id}}</td>
                        <td>{{$employee->lastName}}</td>
                        <td>{{$employee->firstName}}</td>
                        <td>{{$employee->department}}</td>
                        <td>{{$employee->getUserName()}}</td>
                        <td>
                            <div>
                                <a href="/employee/{{$employee->id}}" class="btn btn-primary fa fa-eye col-sm-3"> Übersicht</a>
                                <div class="col-sm-1"></div>
                                <a href="/employee/{{$employee->id}}/activate" class="btn btn-success fa fa-edit col-sm-3"> Reaktivieren</a>
                                <div class="col-sm-1"></div>
                                <form action="{{ route('employee.destroy', $employee) }}" method="POST">
                                    {{ method_field('DELETE') }}
                                    {{ csrf_field() }}
                                    <button class="btn btn-danger fa fa-trash-o col-sm-3"> Löschen</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        $(document).ready(
            function(){
                $('#table_id').DataTable({
                    responsive:true,
                    "order": [[ 2, "asc" ]]
                });
            }
        );
    </script>

@endsection