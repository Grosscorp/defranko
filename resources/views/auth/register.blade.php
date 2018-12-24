@extends('app')

@section('content')
<div class="auth-and-pay">

	<div class="login-content register">
		<div class="blur ">
                	<svg version="1.1" xmlns="http://www.w3.org/2000/svg"> <filter id="blur"> <feGaussianBlur stdDeviation="3" /> </filter> </svg>
                	</div>
		<div class="content-inner">
			<div class="overflow">
                        	<div class="col-sm-13 left-block" >
					<div class="h2 upper">
					RealityJunkie
					</div>
					<div class="h3 upper">
					Sign In to your account
					</div>
						<form class="" role="form" method="POST" action="{{ url('/auth/register') }}">
							@if (count($errors) > 0)
                                                        	<div class="alert alert-danger">

                                                        		<ul>
                                                        			@foreach ($errors->all() as $error)
                                                        				<li>{{ $error }}</li>
                                                        			@endforeach
                                                        		</ul>
                                                        		</div>
                                                        @endif
							<input type="hidden" name="_token" value="{{ csrf_token() }}">

							<div>
								<input type="email" placeholder="Email" class="form-control" name="name" name="email" value="{{ old('email') }}">
							</div>

							<div>
								<input type="password" placeholder="Password" class="form-control" name="password">
							</div>
							<div>
                                                        	<input type="password" placeholder="Password" class="form-control" name="password_confirmation">
                                                        </div>
							<div class="sign-block">
								<button type="submit" class="sing-middle-btn upper text-right powEfect">Sign in <i class="ico-sign-middle"></i></button>
							</div>
						</form>
					</div>
                        	<div class="col-sm-11 right-block">
					<div class="h2 upper">
						or Sign In using

                                        </div>
                                        <a href="/" class="sing-middle-btn upper powEfect"><i class="ico-facebook"></i> facebook</a>
                                        <a href="/" class="sing-middle-btn upper powEfect"><i class="ico-google"></i>google</a>
                        	</div>
                        </div>
                        <div class="overflow bottom-block">
                        	<div class="col-sm-12">
                        		<a class="border-bottom-btn " href="{{ url('/password/email') }}">Forgot Your Password?</a>
                        	</div>
                        	<div class="col-sm-12">
                        	<div class="row">
                        		<div class="col-sm-16 no-padding-right" >
                        			<div class="h3 upper">Don’t have an account?</div>
                        		</div>
                        		<div class="col-sm-8" >
                        			<a href="" class="btn-cast" data-wipe="SIGN UP"> SIGN UP</a>
                        		</div>
                        	</div>
                        	</div>
                        </div>
		</div>
	</div>
</div>
@endsection


