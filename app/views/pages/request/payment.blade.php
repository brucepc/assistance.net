@extends('layouts.paper')
<?php $page_title = trans('request/payment.title') ?>

@section('content')
@include('sections.topbar')
@include('sections.noscript')
@include('sections.topribbons')

<div id='box'>
    <div id='main'>
        <div class='row'>
            <h2>{{ trans('request/payment.title') }}</h2>
            <hr>
        </div>
        <div id='payment_info' class='row'>
            <i class='fa fa-dollar'></i> {{ trans('request/payment.cost') }}
            <br>
            <i></i> {{ trans('request/payment.down_payment') }} 
            <br>
        	<i class='fa fa-clock-o'></i> {{ trans('request/payment.time_to_complete') }} 
            <br>
        	<i class='fa fa-clock-o'></i> {{ trans('request/payment.payment_period') }} 
            <br>
            <i></i> {{ trans('request/payment.other_requirements') }}
      </div>
    </div>
</div>
@include('sections.footer')
@stop


<!--<h3><?php/* echo $other*/?></h3>-->
<!--<h3><?php/* echo $pay_period */?></h3><hr>-->
<!--<h3><?/*php echo $completion_time */?></h3><hr>-->
<!--<h3 class='pull-right'> <?php /* echo $GLOBALS['service']->down_payment*/?></h3><hr>-->
<!--<h3 class='pull-right'><?php /*echo $price */?></h3><hr>-->
<!--
<?php
  /*
  $price = $GLOBALS['service']->price;
  $down_payment = $GLOBALS['service']->down_payment;
  $completion_time = $GLOBALS['service']->completion_time;
  $pay_period = $GLOBALS['service']->pay_period; 
  $other = $GLOBALS['service']->other;
  */
?>
-->