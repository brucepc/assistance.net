@extends('layouts.paper')
<?php $page_title=trans('help/requests.title') ?>

@section('sidebar')
<div class='row'>
    <h4>{{ trans('help/requests.title') }}</h4><hr class='slim'>
    <ul class='icon-list'>
        <li><i class='fa fa-plus-circle'></i><a href='#making_request'>{{ trans('help/requests.new_request') }}</a></li>
        
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
            <h2>{{trans('help/requests.title')}}</h2>
            <hr>
            {{trans('help/requests.questions')}}
        </div>
        <br>
        <br>
        <div id='making_request' class='row'>
           <h4>{{trans('help/requests.new_request')}}</h4>
            <hr>
            <ol>
                <li>{{trans('help/requests.step_1')}}</li>
                <li>{{trans('help/requests.step_2')}}</li>
                <li>{{trans('help/requests.step_3')}}</li>
            </ol>
        </div>
    </div>
</div>
@include('sections.footer')
@stop
