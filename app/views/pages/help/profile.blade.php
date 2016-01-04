@extends('layouts.paper')
<?php $page_title = trans('help/profile.title') ?>

@section('sidebar')
<div class='row'>
    <h4>{{ trans('help/profile.title') }}</h4><hr class='slim'>
    <ul class='icon-list'>
        <li><i class='fa fa-quote-left'></i><a href='#help_name'>{{ trans('help/profile.name.title') }}</a></li>
        <li><i class='fa fa-book'></i><a href='#help_about'>{{ trans('help/profile.about.title') }}</a></li>
        <li><i class='fa fa-briefcase'></i><a href='#help_experience'>{{ trans('help/profile.experience.title') }}</a></li>
        <li><i class='fa fa-phone'></i><a href='#help_contacts'>{{ trans('help/profile.contacts.title') }}</a></li>
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
            <h2>{{ trans('help/profile.title') }}</h2><hr>
            {{ trans('help/profile.subtitle') }}
        </div>
        <div id='help_name' class='row'>
            <h4>{{ trans('help/profile.name.title') }}</h4><hr class='slim'>
            <ol>
                <li>{{ trans('help/profile.name.step_1') }}</li>
                <li>{{ trans('help/profile.name.step_2') }}</li>
                <li>{{ trans('help/profile.name.step_3') }}</li>
            </ol>
        </div>
        <div id='help_about' class='row'>
            <h4>{{ trans('help/profile.about.title') }}</h4><hr class='slim'>
            <ol>
                <li>{{ trans('help/profile.about.step_1') }}</li>
                <li>{{ trans('help/profile.about.step_2') }}</li>
                <li>{{ trans('help/profile.about.step_3') }}</li>
                <li>{{ trans('help/profile.about.step_4') }}</li>
            </ol>
        </div>
        <div id='help_experience' class='row'>
            <h4>{{ trans('help/profile.experience.title') }}</h4><hr class='slim'>
            <ol>
                <li>{{ trans('help/profile.experience.step_1') }}</li>
                <li>{{ trans('help/profile.experience.step_2') }}</li>
                <li>{{ trans('help/profile.experience.step_3') }}</li>
                <li>{{ trans('help/profile.experience.step_4') }}</li>
            </ol>
        </div>
        <div id='help_contacts' class='row'>
            <h4>{{ trans('help/profile.contacts.title') }}</h4><hr class='slim'>

            <ol>
                <li>{{ trans('help/profile.contacts.step_1') }}</li>
                <li>{{ trans('help/profile.contacts.step_2') }}</li> 
                <li>{{ trans('help/profile.contacts.step_3') }}</li>
            </ol>
        </div>
    </div>
</div>
@include('sections.footer')
@stop