@extends('frontend.layouts.app')

@section('title', app_name() . ' | ' . __('navs.frontend.dashboard') )

@section('content')


    <choose-cards></choose-cards>

    <awards></awards>

@endsection
