{{ Form::model(@$experience, [ 'action' => [ 'ProfileController@DoEditProfile', 'experience', $type, @$experience->id ], 'method' => 'post', 'class' => 'experience-form' ]) }}
	<div class='iblock'>
		<div class='column'>
			@if ($errors->has('name'))
				<div class='form-error'>{{ $errors->first('name') }}</div>
			@endif
			{{ Form::label('name', 'Name') }}<br>
			{{ Form::text('name', Input::old('name'), [ 'required' ]) }}
		</div>
		<div class='column'>
			@if ($errors->has('link'))
				<div class='form-error'>{{ $errors->first('link') }}</div>
			@endif
			{{ Form::infolabel('link', 'Link', '(An optional link for more information)') }}<br>
			{{ Form::text('link', Input::old('link')) }}
		</div>
	</div>
	<div class='iblock'>
		<div class='column'>
			@if ($errors->has('start_date'))
				<div class='form-error'>{{ $errors->first('start_date') }}</div>
			@endif
			{{ Form::infolabel('start_date', 'Start Date', '(Leave blank if unknown)') }}<br>
			{{ Form::date('start_date', Input::old('start_date')) }}
		</div>
		<div class='column'>
			@if ($errors->has('end_date'))
				<div class='form-error'>{{ $errors->first('end_date') }}</div>
			@endif
			{{ Form::infolabel('end_date', 'End Date', '(Leave blank if still current)') }}<br>
			{{ Form::date('end_date', Input::old('end_date')) }}
		</div>
	</div><br>
			@if ($errors->has('description'))
				<div class='form-error'>{{ $errors->first('description') }}</div>
			@endif
	{{ Form::label('description', 'Description') }}
	{{ Form::textarea('description', Input::old('description'), [ 'required' ]) }}
	{{ Form::submit(trans('shared.buttons.' . (isset($experience) ? 'update' : 'add')), [ 'class' => 'full-width button-success' ]) }}
{{ Form::close() }}