@extends('page')

@section('head')
@parent
<link rel='stylesheet' href='{{ asset('style/base.css') }}'>
<link rel='stylesheet' href='{{ asset('style/includes.css') }}'>
<style>
body {
	width: 480px;
	height: 800px;
	position: relative;
	margin: auto;
	overflow: hidden;
}
* {
	font-weight: 200;
}
.btm-profile {
	border-bottom: 4px solid #ff7400;
}
.btm-selected {
	border-bottom: 4px solid #f60;
}
#page {
	width: 100%;
	margin: auto;
	position: absolute;
	left: 0;
	right: 0;
	bottom: 0;
	top: 0;
	background: #fff;
	box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}
#topbar {
	position: fixed;
	top: 0;
	left: 0;
	right: 0;
	max-width: 480px;
	margin: auto;
	font-size: 60pt;
	height: 1em;
	background: #fff;
	box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
	text-align: center;
}
.topbar-btm {
	top: inherit !important;
	bottom: 0;
}
.topbar-button {
	display: inline-block;
	font-size: 50%;
	height: 100%;
	float: left;
	width: 20%;
	line-height: 2em;
	color: #333;
}
#topbar-logo-button {
	color: #ff7400;
	margin: auto;
	font-size: 58pt;
	height: 1em;
	line-height: 1em;
	padding: 4px 0;
	background: #fff;
	box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}
#topbar-search {
	position: fixed;
	top: 63pt;
	left: 0;
	right: 0;
	background: #fff;
	max-width: 480px;
	margin: auto;
	box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
	display: none;
	font-size: 180%;
	height: 2em;
}
#topbar-search-input {
	margin: 0;
	padding: 4px;
	border: none;
	font-size: 100%;
	width: 100%;
	height: 100%;
}
#topbar-search-input-container {
	overflow: hidden;
	height: 100%;
}
#topbar-search-submit {
	float: right;
	height: 100%;
	width: 2em;
	text-align: center;
	line-height: 2em;
	font-size: 1em;
	padding: 0;
}
#topbar-spacer {
	font-size: 60pt;
	height: 1em;
	margin-bottom: 30px;
}
#title
{

}
#title-title {
	display: block;
	background: #ff7400;
	color: #fff;
	padding: 2px 4px;
	margin: 20px 0;
}
#title-image {
	border: 4px solid rgba(0, 0, 0, 0.6);
	width: 90%;
	height: 0;
	padding-bottom: 90%;
	margin: auto;
	background: #fff;
	background-repeat: no-repeat;
	background-origin: center;
	background-size: contain;
}
</style>

<script>
$(document).ready(function()
{
	$('#topbar-search-button').on('click', function(ev)
	{
		ev.preventDefault();
		ev.stopPropagation();
		$('#topbar-search').fadeToggle(200);
	});
	$('html').on('click', function(ev)
	{
		ev.preventDefault();
		$tbs = $('#topbar-search');
		if (!$(ev.target).closest($tbs).length)
			$tbs.fadeOut(200);
	})
});
</script>
@stop

@section('body')
<div id='page' class='btm-profile'>
	<div id='topbar' class=''>
		<a title='Profile' 	href='' id='topbar-profile-button'  class='topbar-button fico-person btm-selected'></a>
		<a title='Inbox' 	href='' id='topbar-mail-button' 	 class='topbar-button fico-inbox'></a>
		<a title='Home' 	href='' id='topbar-logo-button' 	 class='topbar-button fico-a'></a>
		<a title='Settings' href='' id='topbar-settings-button' class='topbar-button fico-settings'></a>
		<a title='Help'		href='' id='topbar-search-button' 	 class='topbar-button fa fa-search'></a>
	</div>
	<form id='topbar-search' method='get' action='' tabindex='0'>
		<button tabindex='2' id='topbar-search-submit' class='fa fa-search theme-success'></button>
		<div tabindex='1' id='topbar-search-input-container'><input id='topbar-search-input' placeholder='Search' type='search' name='q'></div>
	</form>
	<div id='topbar-spacer'></div>
	<div id='title'>
		<h1 id='title-title'>Matt Hines</h1>
		<div id='title-image' style='background-image: url("http://www.cs.odu.edu/~mhines/pub/img/me.jpg")'></div>
	</div>
</div>
@stop