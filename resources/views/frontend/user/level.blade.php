@extends('frontend.layouts.app')

@section('title', app_name() . ' | ' . __('navs.frontend.level') )

@section('content')
    <level-vue></level-vue>
@endsection