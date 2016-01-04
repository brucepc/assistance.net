@extends('layouts.paper')
<?php $page_title = trans('help/feedback.title') ?>

@section('sidebar')
<div class='row'>
    <h4>{{ trans('help/feedback.title') }}</h4><hr class='slim'>
    <ul class='icon-list'>
        <li><i class='fa fa-send-o'></i><a href='#submit_feedback'>{{ trans('help/feedback.submit_feedback_form') }}</a></li>
        <li><i class='fa fa-phone-square'></i><a href='#contact_us_form'>{{ trans('help/feedback.contact_us_form') }}</a></li>
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
            <h2>{{trans('help/feedback.title')}}</h2>
            <hr>
            {{trans('help/feedback.subtitle')}}
        </div>
        
        <div id='sumbit_feedback' class='row'>
            <h4>{{trans('help/feedback.submit_feedback_form')}}</h4>
            <hr>
            <ol>
                <li>{{trans('help/feedback.feedback_step_1')}}</li>
                <li>{{trans('help/feedback.feedback_step_2')}}</li>
                <li>{{trans('help/feedback.feedback_step_3')}}</li>
            </ol>
        </div>

        <div id='contact_us_form' class='row'>
            <h4>{{trans('help/feedback.contact_us_form')}}</h4>
             <hr>
             <ol>
                <li>{{trans('help/feedback.contact_step_1')}}</li>
                <li>{{trans('help/feedback.contact_step_2')}}</li>
                <li>{{trans('help/feedback.contact_step_3')}}</li>
                <li>{{trans('help/feedback.contact_step_4')}}</li>
            </ol>
        </div>
    </div>

</div>

@include('sections.footer')
@stop
