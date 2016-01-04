@extends('layouts.paper')
<?php $page_title = $title ?>

@section('content')
@include('sections.topribbons')
<h1>{{ $title }}</h1><hr>
{{ $doc }}
@stop