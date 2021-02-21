@extends('frontend.layouts.app')

@section('title', app_name() . ' | ' . __('navs.frontend.level') )

@section('content')
    <grammar-single></grammar-single>
    <check-width></check-width>
@endsection