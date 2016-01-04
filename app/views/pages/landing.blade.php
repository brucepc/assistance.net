@extends('layouts.metal')

@section('content')
<style>
#landing-search {
    display: inline-block;
}

#search-box {
    .box-sizing(border-box);
    background-color: rgba(255, 255, 255, 0.8);
    color: #000;
    line-height: 40px;
    height: 42px;
    border: 1px solid rgba(0, 0, 0, 0.4);
    border-right: none;
    display: block;
    float: left;
    min-width: 500px;
    margin: 0;
    padding: 2px 8px;
    font-size: 1em;

    &:focus {
        outline: 0;
    }
}
#search-btn {
    height: 48px;
    font-size: 1em;
    float: right;
    display: block;
    margin: 0;
    padding: 0 (@padding);
    border: 1px solid rgba(0, 0, 0, 0.1);
    border-left: none;
}
body {
	margin:0;
}
.va {
	display:table-cell;
	vertical-align:middle;
	width:72px;
}
</style>
<div id='top-bar' style='margin:-10px; padding:7px; background: #EDEDED; border: 0; height:2.5em; display:block;'>
	<div id='top-bar-cont' style='max-width:1100px; margin-left: auto; margin-right: auto;'>
		<form id='landing-login-form' method='post' action='' class='float-right' style='display: inline;'>
			<a class='button button-profile float-right'href='{{ action('LoginController@ShowLogin') }}'>Login</a>
			<!--<input id='login-email' type='email' name='email' placeholder='Email' style='height: 1.3em; font-size: 1.2em;'>
			<input id='login-password' type='password' name='password' placeholder='Password' style='height: 1.3em; font-size: 1.2em;'>-->
		</form> 
		<div class='fico-assistance text-left' style='color: #FF7400; font-size: 2em;'></div>
		<!-- <span class='hint text-left'>{{ trans('landing.slogan') }}</span>-->
	</div>
</div>
<div id='top-cont' style='margin:-10px; padding:0; border:0; background: #F26113; display:block;'>
	<div id='top-cont-cont' style='max-width:1000px; margin-left: auto; margin-right: auto; text-align:center; color: #F0F0F0;'>
		<div class='small-vspace'></div>
		<div id='landing-intro'>
			
			<div class='vspace'></div>
			<h2>Turn your passion into self-empowerment</h2>
			<div class='small-vspace'></div>
			<h3>Assistance allows you to provide or request services in an individual, entrepreneurial environment.
			<div class='vspace'></div>
		</div>

	    <form id='landing-search' action='' method='get'>
	    	<input type='hidden' name='page' value='search'>
	    	<input id='search-box' type='text' name='q' placeholder='Enter any service'>
		    <button id='search-btn' type='submit' class='button theme-request'>Get Started</button>
	    </form>
	    <div class='small-vspace'></div>
	</div>
</div>
<div id='landing-pad' style='max-width:1100px;'>
	<div class='small-vspace'></div>
	<div style='width:60%; max-width: 600px; display:inline-table; font-size:1.4em; text-align:left;'>
		<div style='display:table; padding-bottom:20px;'><i class="fa fa-check va fa-2x"></i><span style='display:table-cell;'>Every time you complete a service, your skills are validated and your reputation grows.</span></div>
		<div style='display:table; padding-bottom:20px;'><i class="fa fa-bar-chart va fa-2x"></i><span style='display:table-cell;'>Our algorithm rewards high quality service - no more race to the bottom.</span></div>
		<div style='display:table; padding-bottom:20px;'><i class="fa fa-language va fa-2x"></i><span style='display:table-cell;'>We make it easy to find your niche - new services can be requested or offered at any time.</span></div>
	</div>
	<div style='width:5%; max-width:50px; display:inline-table; padding:0;'></div>
	<div style='width:35%; max-width: 350px; display:inline-table; padding: 15px;'>
		<h2 style='text-align:left; margin-left:7px;'>Join Us</h2>
		<form id='landing-register-form' method='post' action='' >
			<input id='register-email' type='email' name='email' placeholder='Email' style='width:100%; margin-bottom:14px; margin-top:7px; height: 1.3em; font-size:1.2em;'>
			<input id='register-password' type='password' name='password' placeholder='Password' style='width:100%; margin-bottom:14px; height: 1.3em; font-size:1.2em;'>
			<input id='register-password-confirm' type='password' name='password-confirm' placeholder='Password (Confirm)' style='width:100%; margin-bottom:7px; height: 1.3em; font-size:1.2em;'>
			<a class='button button-profile float-right' href='{{ action('ProfileController@ShowNew') }}'>Join Now</a>
		</form>
	</div>
</div>
@include('sections.footer')
@stop
