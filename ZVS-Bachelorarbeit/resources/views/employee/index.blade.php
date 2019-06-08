@extends('layouts.app')

@section('header')
    Mitarbeiter
@endsection

@section('content')
    <div class="well">
        <a class="btn btn-primary" href="/">Zurück</a>
        <button class="btn btn-warning" type="button" onclick="$(createEmployeeModal).modal('show');">Mitarbeiter Erstellen</button>
        <!--<a class="btn btn-info" href="/employee/deactivated">Deaktivierte Mitarbeiter</a>-->
    </div>
    <div class="panel">
        <div class="panel-body">
            <table id="table_id" class="display table-bordered">
                <thead>
					<tr>
						<th>Mitarbeiter ID</th>
						<th>Name</th>
						<th>Vorname</th>
						<th>Transponder</th>
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
                    @if($employee->hasTransponder())
                            <td>{{$employee->transponder}}</td>
                        @else
                            <td>Kein Transponder</td>
                        @endif
                        <td>{{$employee->getUserName()}}</td>
                        <td>
                            <div>
                                <a href="/employee/{{$employee->id}}" class="btn btn-primary fa fa-eye col-sm-3"> Übersicht</a>
                                <div class="col-sm-1"></div>
                            @if($employee->hasUser())
                                    <form action="{{ route('user.destroy', $employee->getUser()) }}" method="POST">
                                        {{ method_field('DELETE') }}
                                        {{ csrf_field() }}
                                        <button class="btn btn-danger fa fa-trash-o col-sm-3"> Nutzer Löschen</button>
                                    </form>
                                @else
                                    <button class="btn btn-success fa fa-user col-sm-3" type="button" onclick="showCreateUser('{{$employee->firstName}}','{{$employee->lastName}}','{{$employee->id}}')">Nutzer Hinzufügen</button>
                                @endif
                                <div class="col-sm-1"></div>
                                <button class="btn btn-warning fa fa-edit col-sm-3" type="button" onclick=
                                "showEdit('{{$employee->lastName}}','{{$employee->firstName}}','{{$employee->id}}','{{$employee->department}}','{{$employee->transponder}}','{{$employee->hours}}')"
                                >Bearbeiten</button>
								<!--<div class="col-sm-1"></div>
                                <a href="/employee/{{$employee->id}}/deactivate" class="btn btn-danger fa fa-trash-o col-sm-2"> Deaktivieren</a>-->
							</div>
						</td>
					</tr>
				@endforeach
				</tbody>
			</table>
		</div>
	</div>

    <!-- Modal to create User -->
    <div class="modal fade" id="createUserModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="newUserName">Nutzer anlegen</h4>
                </div>
                <div class="modal-body row col-sm-12">
                    <form class="form-horizontal" id="createUserForm" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                            <label for="username" class="col-md-4 control-label">Nutzername</label>

                            <div class="col-md-6">
                                <input id="username" type="username" class="form-control" name="username" value="{{ old('username') }}" required>

                                @if ($errors->has('username'))
                                    <span class="help-block">
										<strong>{{ $errors->first('username') }}</strong>
									</span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('userType') ? ' has-error' : '' }}">
                            <label for="userType" class="col-md-4 control-label">Nutzer Art</label>

                            <div class="col-md-6">
                                {{Form::select('userType', array('admin' => 'Admin', 'employee' => 'Mitarbeiter'),null,['class' => 'form-control'])}}

                                @if ($errors->has('userType'))
                                    <span class="help-block">
										<strong>{{ $errors->first('userType') }}</strong>
									</span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="employee" class="col-md-4 control-label">Mitarbeiter</label>
                            <div class="col-md-6">
                                <input id="employee" type="number   " class="form-control" name="employee" value="{{ old('employee') }}">

                                @if ($errors->has('employee'))
                                    <span class="help-block">
										<strong>{{ $errors->first('employee') }}</strong>
									</span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
										<strong>{{ $errors->first('password') }}</strong>
									</span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-primary" value="Submit" id="createUserButton" />
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Abbrechen</button>
                </div>
            </div>

        </div>
    </div>

    <!-- Modal to create Employee -->
    <div class="modal fade" id="createEmployeeModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Neuen Mitarbeiter anlegen</h4>
                </div>
                <div class="modal-body row col-sm-12">
                    <form action="{{ route('employee.store') }}" method="POST" id="createEmployeeForm">
                        <div class="form-row col-sm-12">
                            <div class="form-group col-sm-6">
                                {{Form::label('lastName', 'Name')}}
                                {{Form::text('lastName','',['class' => 'form-control', 'placeholder' => 'Name'])}}
                            </div>
                        </div>
                        <div class="form-row col-sm-12">
                            <div class="form-group col-sm-6">
                                {{Form::label('firstName', 'Vorname')}}
                                {{Form::text('firstName','',['class' => 'form-control', 'placeholder' => 'Vorname'])}}
                            </div>
                        </div>
                        <div class="form-row col-sm-12">
                            <div class="form-group col-sm-6">
                                {{Form::label('id', 'Mitarbeiter Nummer')}}
                                {{Form::number('id','',['class' => 'form-control', 'placeholder' => ''])}}
                            </div>
                        </div>
                        <div class="form-row col-sm-12">
                            <div class="form-group col-sm-6">
                                {{Form::label('department', 'Abteilung')}}
                                {{Form::text('department','',['class' => 'form-control', 'placeholder' => 'Abteilung'])}}
                            </div>
                        </div>
                        <div class="form-row col-sm-12">
                            <div class="form-group col-sm-6">
                                {{Form::label('transponder', 'Transponder')}}
                                {{Form::text('transponder','',['class' => 'form-control', 'placeholder' => 'Transponder'])}}
                            </div>
                        </div>
                        <div class="form-row col-sm-12">
                            <div class="form-group col-sm-6">
                                {{Form::label('hours', 'Wochenstunden')}}
                                {{Form::text('hours','',['class'=>'form-control','placeholder'=>'0'])}}
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-primary" value="Submit" id="createEmployeeButton" />
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Abbrechen</button>
                </div>
            </div>

        </div>
    </div>

    <!-- Modal to edit Employee -->
    <div class="modal fade" id="editEmployeeModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Mitarbeiter bearbeiten</h4>
                </div>
                <div class="modal-body row col-sm-12">
                    <form action="{{ action('employeeController@update', ['employee' => $employee->id]) }}" method="POST" id="editEmployeeForm">
                        <div class="form-row col-sm-12">
                            <div class="form-group col-sm-6">
                                {{Form::label('lastName', 'Name')}}
                                {{Form::text('lastName','',['class' => 'form-control lastName', 'placeholder' => 'Name'])}}
                            </div>
                        </div>
                        <div class="form-row col-sm-12">
                            <div class="form-group col-sm-6">
                                {{Form::label('firstName', 'Vorname')}}
                                {{Form::text('firstName','',['class' => 'form-control firstName', 'placeholder' => 'Vorname'])}}
                            </div>
                        </div>
                        <div class="form-row col-sm-12">
                            <div class="form-group col-sm-6">
                                {{Form::label('department', 'Abteilung')}}
                                {{Form::text('department','',['class' => 'form-control department', 'placeholder' => 'Abteilung'])}}
                            </div>
                        </div>
                        <div class="form-row col-sm-12">
                            <div class="form-group col-sm-6">
                                {{Form::label('transponder', 'Transponder')}}
                                {{Form::number('transponder','',['class' => 'form-control transponder', 'placeholder' => 'Transponder'])}}
                            </div>
                        </div>
                        <div class="form-row col-sm-12">
                            <div class="form-group col-sm-6">
                                {{Form::label('hours', 'Wochenstunden')}}
                                {{Form::number('hours','',['class'=>'form-control hours','placeholder'=>'0'])}}
                            </div>
                        </div>
                        {{csrf_field()}}
                        {{Form::hidden('_method', 'PUT')}}
                        {{Form::hidden('id',null,['class'=>'id'])}}
                    </form>
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-primary" value="Submit" id="editEmployeeButton" />
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Abbrechen</button>
                </div>
            </div>

        </div>
    </div>

@endsection

@section('scripts')
    <!--<script>
        $(document).ready(
            function(){
                $('#table_id').DataTable({
                    responsive:true,
                    "order": [[ 2, "asc" ]]
                });
            }
        );
    </script>-->

    <!-- Show Create User Form -->
    <script>
        function showCreateUser(firstName, lastName, id) {

            var newName = name.toString();

            document.getElementById("newUserName").innerHTML = 'Neuer Nutzer für '+ firstName + ' ' + lastName;
            document.getElementById("username").value = "";
            document.getElementById("employee").value = id;
            document.getElementById("password").value = "";
            document.getElementById("password-confirm").value = "";

            $(createUserModal).modal('show');
        }
    </script>

    <!-- Submit New User Form -->
    <script type="text/javascript">
        $(document).ready(function() {
            $("#createUserButton").click(function() {
                $("#createUserForm").submit();
            });
        });
    </script>

    <!-- Submit New Employee Form -->
    <script type="t\PMA\libraries\config\ext/javascript">
        $(document).ready(function() {
            $("#createEmployeeButton").click(function() {
                $("#createEmployeeForm").submit();
            });
        });
    </script>

    <!-- Show Edit Employee Form -->
    <script>
        function showEdit(lastName, firstName, id, department, transponder, hours) {

            var newLastName = lastName.toString();
            var newFirstName = firstName.toString();
            var newDepartment= department.toString();

            document.getElementsByClassName("lastName")[0].value = newLastName;
            document.getElementsByClassName("firstName")[0].value = newFirstName;
            document.getElementsByClassName("id")[0].value = id;
            document.getElementsByClassName("department")[0].value = newDepartment;
            document.getElementsByClassName("transponder")[0].value = transponder;
            document.getElementsByClassName("hours")[0].value = hours;

            document.getElementById('editEmployeeForm').action = '/employee/'+id;

            $(editEmployeeModal).modal('show');
        }
    </script>

    <!-- Submit Edit Employee Form -->
    <script type="text/javascript">
        $(document).ready(function() {
            $("#editEmployeeButton").click(function() {
                $("#editEmployeeForm").submit();
            });
        });
    </script>

@endsection