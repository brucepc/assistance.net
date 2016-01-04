@extends('layouts.paper')
<?php $page_title = trans('extlink.title') ?>

@section('head')
@parent
<style type='text/css'>
    #msg-name {
        margin: auto;
        max-width: 90%;
        word-wrap: break-word;
    }
</style>
@stop

@section('content')
@include('sections.topbar')
@include('sections.topribbons')

<div class='vspace'></div>
<div class='text-center'>
    <h1 class='theme-warning pad'>{{ trans('extlink.title') }}</h1>
    <div class='vspace'></div>
    <div class='bold'>{{ trans('extlink.warning') }}</div>
    <a class='link-default small' href=''>{{ trans('extlink.report') }}</a>
    <div class='vspace'></div>
    <a class='link-indeterminate big' href='{{ $link }}'>{{{ $link }}}</a>
    <div class='show-js'>
        <div class='vspace'></div>
        <a id='extlink-go-back' class='button-error button' href='javascript:history.back()'><i class='fa fa-chevron-left space-right'></i> {{ trans('shared.buttons.go_back') }}</a>
    </div>
</div>
@include('sections.footer')
@stop
