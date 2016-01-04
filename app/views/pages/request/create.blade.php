@extends('layouts.paper')
<?php $page_title = Lang::get('request/create.title'); ?>

@section('content')
@include('sections.topbar')
@include('sections.noscript')
@include('sections.topribbons')
<div id='box'>
	<div id='main'>
		<!--<form id='create-form' action="submit" method='post'>-->
		{{ Form::open(['action' => 'RequestController@DoCreate', 'id' => 'create-form', 'autocomplete' => 'off']) }}
		<div id='info' class='row'>
			<h1>{{ trans('request/create.title') }}</h1>
			<br>
			<h2>{{ trans('request/create.basic_information') }}</h2>
			<div class='hint'>{{ trans('request/create.basic_request_info') }}</div>
			<label for='name'>Name</label><br>
			<input type='text' name='name' value=''>
		</div>
		<div id='location' class='row'>
			<h2 >{{ trans('request/create.location') }}</h2>
			<div class='hint'>{{ trans('request/create.location_choice') }}</div>
			<input type='radio' name='location' id='creator' value='mine'><label for='creator'>Your location</label><br>
			<input type='radio' name='location' id='receiver' value='theirs'><label for='receiver'>Receiver's location</label><br>
			<input type='radio' name='location' id='other' value='other'><label for='other'>Other: </label>
			<input type='text' name='location_other_input' value=''><br>
			<input type='radio' name='location' id='digital' value='digital'><label for='digital'>Digital service</label><br>
		</div>
		<br>
		<div id='category' class='row'>
			<h2 id='hcategory' >{{ trans('request/create.category') }}</h2>
			<div class='hint'>{{ trans('request/create.category_choice') }}</div>
			<div id='category-selection' class='relative'>
				<div id='category-loader'></div>
			</div>
			<br>
			<h2 id='skills'>{{ trans('request/create.skills') }}</h2>
			<div class='hint'>{{ trans('request/create.skills_indication') }}</div>
			<div id='skills-box'></div>
			<input type='text' id='skills-input' name='skills'>
		</div>
		<hr>
		<div id='request_footer' class='row'>
			<div class='pull-left hint'>{{ trans('request/create.customizations') }}</div>
			<input type='submit' value='Create Request' class='pull-right theme-success'>
		</div>
		<!--</form>-->
		{{ Form::close() }}

	</div>
</div>
@include('sections.footer')
@stop