@extends('frontend.layouts.app')

@section('title', app_name() . ' | ' . __('navs.frontend.dashboard') )

@section('content')


    <choose-cards></choose-cards>

    <awards-new></awards-new>

@endsection
