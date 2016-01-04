@extends('layouts.paper')
<?php $page_title=trans('help/services.title') ?>

@section('sidebar')
<div class='row'>
    <h4>{{ trans('help/services.title') }}</h4><hr class='slim'>
    <ul class='icon-list'>
        <li><i class='fa fa-plus-circle'></i><a href='#making_service'>{{ trans('help/services.create') }}</a></li>
        <li><i class='fa fa-legal'></i><a href='#negotiation'>{{ trans('help/services.negotiation') }}</a></li>
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
            <h2>{{trans('help/services.title')}}</h2>
            <hr>
            {{trans('help/services.subtitle')}}
        </div>

        <div id="making_service" class='row'>
            <p>{{trans('help/services.create')}}</p>
            <hr>
            <ol>
                <li>{{trans('help/services.step_1')}}</li>
                <li>{{trans('help/services.step_2')}}</li>
                <li>{{trans('help/services.step_3')}}</li>
            </ol>
        </div>
        
        <div id='negotation' class='row'>
            <h4>{{trans('help/services.negotiation')}}</h4>
            <hr>
                {{trans('help/services.negotiation_info')}}
        </div>
    </div>
</div>
@include('sections.footer')
@stop
