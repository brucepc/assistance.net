@extends('layouts.metal')
<?php $page_title = Lang::get('login/logout.page_title') ?>

@section('head')
@parent
<script type="text/javascript">
// Our countdown plugin takes a callback, a duration, and an optional message
$(document).ready(function ()
{
    var elm = $('#countdown');
    var duration = 3;
    elm.html(duration);
    var countdown = setInterval(function ()
    {
        if (--duration > -1)
            elm.fadeOut(250, function () { $(this).html(duration).fadeIn(250) });
        else
        {
            clearInterval(countdown);
            $('#countdown-wrap').fadeOut(250);
            window.location = "{{ route('home') }}";
        }
    }, 1000);
});
</script>
@stop

@section('content')
<noscript><meta http-equiv='refresh' content='3; url={{ route('home') }}'></noscript>
<div class='absolute fix-all text-center' style='margin: auto; height: 8em'>
    <a href='{{ route('home') }}' class='fico-assistance color-profile huge space-bottom block no-link'></a>
    <div class='space-vertical'>{{ trans('login/logout.message') }}</div>
    <a id='countdown-wrap' href='{{ route('home') }}' class='hint center block'>{{ trans('login/logout.timeout', ['seconds' => '<span id=\'countdown\'>3</span>']) }}</a>
</div>
@include('sections.footer')
@stop