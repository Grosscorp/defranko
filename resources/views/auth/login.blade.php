@extends('auth')

@section('content')
	<form class="" role="form" method="POST" action="{{ url('/auth/login') }}">
		@if (count($errors) > 0)
			<div class="alert alert-danger">
				<strong>Whoops!</strong> There were some problems with your input.<br><br>
				<ul class="u-listUnstyled">
					@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
		@endif
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="m-b-30">
				<div class="form-group">
					<label>Email</label>
					<div class="controls">
						<input type="email" placeholder="Email" class="form-control" name="email" value="{{ old('email') }}">
					</div>
				</div>


				<div class="form-group">
					<label>Password</label>
					<div class="controls">
						<input type="password" placeholder="Password" class="form-control" name="password">
					</div>
				</div>

				<div>
					<button type="submit" class="btn btn-primary btn-cons m-t-10">Sign in </button>
				</div>
			</div>

			{{--<a class="border-bottom-btn " href="{{ url('/password/email') }}">Forgot Your Password?</a>--}}
			{{--<a href="" class="text-info small" data-wipe="SIGN UP"> SIGN UP</a>--}}
	</form>

@endsection
