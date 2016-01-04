@extends('layouts.paper')

@section('title-lr')
<div id='title-left'>@include('sections.profile.tlist', $services_list)</div>
<div id='title-right'>@include('sections.profile.tlist', $requests_list)</div>
@stop

@section('content')
@include('sections.topbar')
@include('sections.noscript')
@include('sections.topribbons')
@include('sections.title', $title_info)

<div id='box'>
	<div id='sidebar'>
		<div id='contact' class='row'>
			<h2>{{ trans('profile/profile.contact.title') }}</h2><hr>
			<ul class='icon-list'>
				<?php $cc = 0; ?>
				@if ($profile->address) <?php $cc++ ?> <li title='Address'><i class='fa fa-location-arrow stroke-13'></i><a href='http://www.openstreetmap.org/search?query={{{ e($profile->address) }}}'>{{{ $profile->address }}}</a></li> @endif
				@if ($profile->home_phone) <?php $cc++ ?> <li title='Home Phone'><i class='fa fa-phone stroke-14'></i><a href='tel:{{{ $profile->home_phone }}}'>{{{ $profile->home_phone }}}</a></li> @endif
				@if ($profile->cell_phone) <?php $cc++ ?> <li title='Cell Phone'><i class='fa fa-mobile stroke-2'></i><a href='tel:{{{ $profile->cell_phone }}}'>{{{ $profile->cell_phone }}}</a></li> @endif
				@if ($profile->work_phone) <?php $cc++ ?> <li title='Work Phone'><i class='fa fa-fax stroke-19'></i><a href='tel:{{{ $profile->work_phone }}}'>{{{ $profile->work_phone }}}</a></li> @endif
				@if ($profile->public_email) <?php $cc++ ?> <li title='Public Email'><i class='fa fa-envelope stroke-10'></i><a href='mailto:{{{ $profile->public_email }}}'>{{{ $profile->public_email }}}</a></li> @endif
				@if ($profile->website) <?php $cc++ ?> <li title='Website'><i class='fa fa-globe stroke-18'></i><a href='{{{ route('extlink', [ $profile->website ]) }}}'>{{{ $profile->website }}}</a></li> @endif
				@if ($cc > 0) <hr class='space-horizontal slim'> @endif
				@if ($profile->linkedin) <?php $cc++ ?> <li class='social' title='LinkedIn'><i class='fa fa-linkedin-square' style='color: #069'></i><a href='https://www.linkedin.com/'>LinkedIn</a></li> @endif
				@if ($profile->facebook) <?php $cc++ ?> <li title='Facebook'><i class='fa fa-facebook-square' style='color: #3b5998'></i><a href='https://www.facebook.com/'>Facebook</a></li> @endif
				@if ($profile->googleplus) <?php $cc++ ?> <li title='Google+'><i class='fa fa-google-plus-square' style='color: #dd4b39'></i><a href='https://plus.google.com/'>Google</a></li> @endif
				@if ($profile->twitter) <?php $cc++ ?> <li title='Twitter'><i class='fa fa-twitter' style='color: #55acee'></i><a href='https://www.twitter.com/'>Twitter</a></li> @endif
				@if ($profile->instagram) <?php $cc++ ?> <li title='Instagram'><i class='fa fa-instagram' style='color: #517fa4'></i><a href='https://www.instagram.com/'>Instagram</a></li> @endif
				@if ($profile->tumblr) <?php $cc++ ?> <li title='Tumblr'><i class='fa fa-tumblr-square' style='color: #2c4762'></i><a href='https://www.tumblr.com/'>Tumblr</a></li> @endif
				@if ($profile->pinterest) <?php $cc++ ?> <li title='Pinterest'><i class='fa fa-pinterest-square' style='color: #cb2027'></i><a href='https://www.pinterest.com/'>Pinterest</a></li> @endif
				@if ($profile->flickr) <?php $cc++ ?> <li title='Flickr'><i class='fa fa-flickr' style='color: #0063db'></i><a href='https://www.flickr.com/'>Flickr</a></li> @endif
				@if ($profile->skype) <?php $cc++ ?> <li title='Skype'><i class='fa fa-skype' style='color: #00aff0'></i><a href='skype:|userinfo'>Skype</a></li> @endif
				@if ($profile->youtube) <?php $cc++ ?> <li title='YouTube'><i class='fa fa-youtube-play' style='color: #cc181e'></i><a href='https://www.youtube.com'>YouTube</a></li> @endif
				@if ($profile->vimeo) <?php $cc++ ?> <li title='Vimeo'><i class='fa fa-vimeo-square' style='color: #1ca7cc'></i><a href='https://www.vimeo.com'>Vimeo</a></li> @endif

				@if ($cc < 1) <div class='hint'>You have no contact info.</div> @endif
			</ul>
		</div>
	</div>
	<div id='main'>
		<div id='about' class='row'>
			<h2>
				About me
				@if ($is_me)
				@if ($edit == 'about')
				<a href='{{ action('ProfileController@ShowProfile', [ null ]) }}' class='link-error edit-button'>{{ trans('shared.buttons.cancel') }}</a>
				@else
				<a href='{{ action('ProfileController@ShowEditProfile', [ 'about' ]) }}' class='link-indeterminate edit-button'>{{ trans('shared.buttons.edit') }}</a>
				@endif
				@endif
			</h2><hr>
			@if ($is_me && $edit == 'about')
			{{ Form::open([ 'action' => [ 'ProfileController@DoEditProfile', 'about' ], 'method' => 'post' ]) }}
			<textarea autofocus id='about_textarea' name='about' placeholder='{{ trans('profile/profile.about.placeholder') }}'>{{{ $profile->about }}}</textarea>
			<button class='full-width button-success'>{{ trans('shared.buttons.update') }}</button>
			{{ Form::close() }}
			<div class='small-vspace'></div>
			@elseif (!$profile->about)
			<div class='hint'>{{ trans('profile/profile.about.' . ($is_me ? 'my_none' : 'none')) }}</div>
			@else
			{{{ $profile->about }}}
			@endif
		</div>
		<div id='skills' class='row'>
			<h2>{{ trans('profile/profile.skills.title') }}</h2><hr>
			@if (count(@$skills) < 1)
			<div class='hint'>{{ trans('profile/profile.skills.' . ($is_me ? 'my_none' : 'none')) }}</div>
			@else
			@foreach ($skills as $k => $v)
			<div class='skill'>
				<a href='' class='link-skill'>{{{ $k }}}</a><sub>{{{ $v }}}</sub>
			</div>
			@endforeach
			@endif
		</div>

		<div id='experience' class='row'>
			<h2>
				{{ trans('profile/profile.experience.title') }}
				@if ($is_me)
				@if ($edit == 'experience')
				<a href='{{ action('ProfileController@ShowProfile', [ null ]) }}' class='link-error edit-button'>{{ trans('shared.buttons.cancel') }}</a>
				@else
				<a href='{{ action('ProfileController@ShowEditProfile', [ 'experience' ]) }}' class='link-indeterminate edit-button'>{{ trans('shared.buttons.edit') }}</a>
				@endif
				@endif
			</h2><hr>
			@if ($profile->experiences->count() >= 1)
			<ol>
				@foreach ($profile->experiences as $exp)
				<li @if ($edit == 'experience') class='pad-list' @endif>
					@if ($edit_which == $exp->id)
					@include('sections.profile.expform', [ 'experience' => $exp, 'type' => 'edit' ])
					@else
					@if (!empty($exp->link))
					<a class='experience' href='{{ route('extlink', [ $exp->link ]) }}'>
					@else
					<div class='experience'>
						@endif
						@if ($edit == 'experience')
						<div class='mod-buttons float-left pad-right'>
							<a href='{{ action('ProfileController@ShowEditProfile', [ 'experience', $exp->id ]) }}' class='iblock fico-document link-indeterminate no-link'></a>
							<br>
							<a href='{{ action('ProfileController@DoEditProfileDelete', [ 'experience', $exp->id ]) }}' class='iblock fico-x link-error no-link'></a>
						</div>
						@endif
						<h4 class='iblock'>{{{ $exp->name }}}</h4>
						<span class='hint space-left'>
							@if ($exp->start_date)
							<strong>{{{ date('Y M j', $exp->start_date) }}}</strong>
							{{ trans('profile/profile.experience.date_to') }}
							@if ($exp->end_date)
							<strong>{{{ date('Y M j', $exp->end_date) }}}</strong>
							@else
							{{ trans('profile/profile.experience.date_now') }}
							@endif
							@elseif ($exp->end_date)
							<strong>{{{ date('Y M j', $exp->end_date) }}}</strong>
							@endif
						</span>
						<p>{{{ $exp->description }}}</p>
						@if (!empty($exp->link))
					</a>
					@else
				</div>
				@endif
				@endif
				</li>
				@endforeach
			</ol>
			@endif
			@if ($edit == 'experience' && !$edit_which)
			@if (count($profile->experiences) >= 1)
			<div class='small-vspace'></div>
			@endif
			<strong>Add a new Experience</strong>
			@include('sections.profile.expform', [ 'type' => 'new' ])
			@elseif (count($profile->experiences) < 1)
			<div class='hint'>{{ trans('profile/profile.experience.' . ($is_me ? 'my_none' : 'none')) }}</div>
			@endif
		</div>
	</div>
</div>

@include('sections.footer')
@stop