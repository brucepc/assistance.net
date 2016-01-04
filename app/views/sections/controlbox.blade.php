@section('head')
@parent
<script type='text/javascript' src='{{ asset('scripts/content/topbar.js') }}'></script>
@stop
<a title='{{ trans('shared.controlbox.debug') }}' href='' class='topbar-button fa-spin fa fa-cog' id='top-debug-button' tabindex='0'></a>
<a title='{{ trans('shared.controlbox.feedback') }}' href='' class='topbar-button fico-feedback' id='top-feedback-button' tabindex='0'></a>

@if (Auth::check())
<a title='{{ trans('shared.controlbox.new') }}' href='' class='topbar-button fico-new' id='top-new-button' tabindex='0'></a>
<a title='{{ trans('shared.controlbox.profile') }}' href='{{ action('ProfileController@ShowMe') }}' class='topbar-button fico-person' id='top-profile-button' tabindex='0'></a>
<a title='{{ trans('shared.controlbox.inbox') }}' href='' class='topbar-button fico-inbox relative' id='top-inbox-button' tabindex='0'>
	<div id='top-mail-notif'><div id='top-mail-notif-counter'></div></div>
</a>
<a title='{{ trans('shared.controlbox.settings') }}' href='' class='topbar-button fico-settings' id='top-settings-button' tabindex='0'></a>
@else
<a title='{{ trans('shared.controlbox.login') }}' href='{{ action('LoginController@ShowLogin') }}' class='topbar-button fico-person' id='top-login-button' tabindex='0'></a>
@endif
<a title='{{ trans('shared.controlbox.help') }}' href='{{ route('help') }}' class='topbar-button fico-help' id='top-help-button' tabindex='0'></a>