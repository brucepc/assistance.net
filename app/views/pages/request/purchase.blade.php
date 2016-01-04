@extends('layouts.paper')
<?php $page_title = trans('request/purchase.title') ?>

@section('content')
@include('sections.topbar')
@include('sections.noscript')
@include('sections.topribbons')

<div id='box'>
    <div id='main'>
        <div class='row'>
            <h2>{{trans('request/purchase.title')}}</h2>
            <hr>
        </div>
        <div id='info' class='row'>
            <div class='icon-list'>
                <i class='fa fa-dollar'></i><h3 title='(Calculated) Price'></h3>
                <i class='fa fa-clock-o'></i><h3 title='(Calculated) Time to complete'></h3>
                <i class='fa fa-tag'></i><h3 title='Category'></h3>
            </div>
        </div> 
        <div id='actions' class='row'>
            <a class='button theme-error' href=''>{{trans('request/purchase.cancel_service')}}</a>
            <a class='button theme-indeterminate'>{{trans('request/purchase.reconfigure_service')}}</a>
            <a href='' class='button theme-service'>{{trans('request/purchase.buy_now')}}</a>
            <!--<a href="" class='button theme-service'>Add to Cart</a> -->
             <a href='' class='button theme-request'>{{trans('request/purchase.negotiate')}}</a>
            <!--<a class='button theme-request'>Negotiate</a> -->
        </div>
    </div>
</div>
@include('sections.footer')
@stop
