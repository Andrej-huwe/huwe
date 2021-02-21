@extends('frontend.layouts.app')

@section('title', app_name() . ' | ' . __('navs.frontend.level') )

@section('content')
    <grammar-vue></grammar-vue>
    <footer-vue></footer-vue>
    <check-width></check-width>
@endsection