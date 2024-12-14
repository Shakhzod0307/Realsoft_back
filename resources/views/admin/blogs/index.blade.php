@extends('admin.index')
@section('content')
    <blog-component
        :locale="'{{ app()->getLocale() }}'"
        :urls="{{ json_encode(LaravelLocalization::getSupportedLocales()) }}"
    ></blog-component>
@endsection
