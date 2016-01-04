@extends('layouts.paper')
<?php $page_title=trans('help/payment.title') ?>

@section('sidebar')
<div class='row'>
    <h4>{{ trans('help/payment.title') }}</h4><hr class='slim'>
    <ul class='icon-list'>
        <li><i class='fa fa-umbrella'></i><a href='#overview'>{{ trans('help/payment.overview') }}</a></li>
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
        <div id='row'>
            <h2>{{trans('help/payment.title')}}</h2>
            <hr>
            {{trans('help/payment.have_questions')}}
        </div>
        <div id='overview' class='row'>
        <h4>{{trans('help/payment.overview')}}</h4>
        <hr >
          {{trans('help/payment.info')}}
    </div>
    </div>
</div>
@include('sections.footer')
@stop