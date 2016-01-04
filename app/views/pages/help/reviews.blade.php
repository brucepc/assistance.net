@extends('layouts.paper')
<?php $page_title = trans('help/reviews.title') ?>

@section('sidebar')
<div class='row'>
    <h4>{{ trans('help/reviews.title') }}</h4><hr class='slim'>
    <ul class='icon-list'>
        <li><i class='fa fa-umbrella'></i><a href='#overview'>{{ trans('help/reviews.overview') }}</a></li>
        <li><i class='fa fa-user'></i><a href='#impact'>{{ trans('help/reviews.impact') }}</a></li>
    </ul>
</div>
@stop

@section('content')
@include('sections.topbar')
@include('sections.noscript')
@include('sections.topribbons')


<div id='box'>
    @include('sections.help.sidebar')
    <div id='main'>
        <div class='row'>
            <h2>{{trans('help/reviews.title')}}</h2>
            <hr>
            {{trans('help/reviews.subtitle')}}
        </div>

        <div id='overview' class='row'>
            <h4>{{trans('help/reviews.overview')}}</h4>
            <hr >
               {{trans('help/reviews.overview_info')}}
        </div>

        <div id='impact' class='row'>
            <h4>{{trans('help/reviews.impact')}}</h4>
            <hr>
               {{trans('help/reviews.impact_info')}}
        </div>
    </div>
</div>
@include('sections.footer')
@stop