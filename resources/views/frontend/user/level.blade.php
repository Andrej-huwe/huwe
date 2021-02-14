@extends('frontend.layouts.app')

@section('title', app_name() . ' | ' . __('navs.frontend.level') )

@section('content')
    <level-vue></level-vue>
    <check-width></check-width>
    <footer-vue></footer-vue>
@endsection