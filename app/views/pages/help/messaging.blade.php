@extends('layouts.paper')
<?php $page_title = trans('help/messaging.title'); ?>

@section('sidebar')
<div class='row'>
    <h4>{{ trans('help/messaging.title') }}</h4><hr class='slim'>
    <ul class='icon-list'>
        <li><i class='fa fa-pencil-square-o'></i><a href='#help_how'>{{ trans('help/messaging.how') }}</a></li>
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
            <h2>{{trans('help/messaging.title')}}</h2>
            <hr>
            {{trans('help/messaging.subtitle')}}
        </div>
        <div id='help_how' class='row'>
            <h4>{{trans('help/messaging.how')}}</h4>
            <hr>
            <ol>
                <li>{{trans('help/messaging.step_1')}}</li>
                <li>{{trans('help/messaging.step_2')}}</li> 
                <li>{{trans('help/messaging.step_3')}}</li>
                <li>{{trans('help/messaging.step_4')}}</li>
                <li>I{{trans('help/messaging.step_5')}}</li>
            </ol>
        </div>
    </div>
</div>

@include('sections.footer')
@stop