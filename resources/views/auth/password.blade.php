@extends('app')

@section('content')
<div class="auth-and-pay ">

	<div class="login-content forgot-password">
	<div class="blur password">
                	<svg version="1.1" xmlns="http://www.w3.org/2000/svg"> <filter id="blur"> <feGaussianBlur stdDeviation="3" /> </filter> </svg>
                	</div>
		<div class="content-inner ">
			<div class="h2 upper">
                        	RealityJunkie
                        </div>
                        <div class="h3 upper">
                                Forgot your password?
                        </div>
							@if (session('status'))
								<div class="alert alert-success">
									{{ session('status') }}
								</div>
							@endif

							@if (count($errors) > 0)
								<div class="alert alert-danger">
									<strong>Whoops!</strong> There were some problems with your input.<br><br>
									<ul>
										@foreach ($errors->all() as $error)
											<li>{{ $error }}</li>
										@endforeach
									</ul>
								</div>
							@endif

							<form class="form-horizontal" role="form" method="POST" action="{{ url('/password/email') }}">
								<input type="hidden" name="_token" value="{{ csrf_token() }}">
								<div class="row">
									<div class="col-sm-14">
										<input type="email" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}">
									</div>
									<div class="col-sm-10 no-padding-left">
										<button type="submit" class="btn-cast upper">
                                                                                	SEND ME INSTRUCTIONS
                                                                                </button>
									</div>
								</div>
							</form>
                        <div class="row bottom-block">
                        	<div class="col-sm-12">
                        		<div class="col-sm-17 no-padding-left no-padding-right " >
                                         	<div class="h3 upper">Already have an account?</div>
                                        </div>
                                        <div class="col-sm-7" >
                                                <a href="" class="btn-cast" data-wipe="SIGN UP">SIGN IN</a>
                                        </div>
                        	</div>
                        	<div class="col-sm-12">
                        	<div class="row">
                        		<div class="col-sm-16 no-padding-right " >
                        			<div class="h3 upper">Don’t have an account?</div>
                        		</div>
                        		<div class="col-sm-8 text-right no-padding-right " >
                        			<a href="" class="btn-cast" data-wipe="SIGN UP"> SIGN UP</a>
                        		</div>
                        	</div>
                        	</div>
                        </div>
		</div>

	</div>

</div>
@endsection
