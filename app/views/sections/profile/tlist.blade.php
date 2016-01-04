<h2 class='theme-{{{ $theme }}} pad-text'>
	{{{ $title }}}
	<div class='title-lr-subtitle'>
		{{{ @$right_top }}}<br>{{{ @$right_bottom }}}
	</div>
</h2>
@if (count($list) < 1)
	<div class='hint space-left space-top'>{{ $none }}</div>
@else
	<ul>
		<?php $i = 0; ?>
		@foreach ($list as $name => $link)
		<li><a href='{{{ $link }}}'>{{{ $name }}}</a></li>
		<?php if (++$i >= $max) break; ?>
		@endforeach
	</ul>
	@if (count($list) > $max)
		<a class='space-left' href='{{ $more }}'>{{ trans('profile/profile.title.more') }}</a>
	@endif
@endif