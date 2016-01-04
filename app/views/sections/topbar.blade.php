<header id='topbar'>
	<div id='topbar-logo-area'>
		<a title='Assistance' href='{{ route('home') }}' id='topbar-logo' class='fico-assistance color-{{{ $theme }}}'></a>
		<span id='topbar-logo-badge' class='color-{{{ $theme }}}'>&beta;</span>
	</div>
	<form id='topbar-search' action='' method='get'>
		<input id='topbar-search-q' type='text' name='q' value='' placeholder='{{ trans('shared.search') }}'>
	</form>
	<nav id='control-box'>
		@include('sections.controlbox')
	</nav>
</header>
<div id="topbar-spacer"></div>