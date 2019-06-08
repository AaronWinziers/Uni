@extends('layouts.app')

@section('header')
    Nutzer erzeugen
@endsection

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Register</div>

				<div class="panel-body">
					<form class="form-horizontal" method="POST" action="{{ route('register') }}">
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
								<input id="userType" type="text" class="form-control" name="userType" value="{{ old('userType') }}" >

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
								<input id="employee" type="text" class="form-control" name="employee" value="{{ old('employee') }}">

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

						<div class="form-group">
							<div class="col-md-2 col-md-offset-4">
								<button type="submit" class="btn btn-primary">
									Register
								</button>
							</div>
                            <a class="btn btn-danger" href="/user">Abbrechen</a>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
