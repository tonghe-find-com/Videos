@extends('core::admin.master')

@section('title', __('New videopage'))

@section('content')

    <div class="header">
        @include('core::admin._button-back', ['module' => 'videocategories'])
        <h1 class="header-title">@lang('New videopage')</h1>
    </div>

    {!! BootForm::open()->action(route('admin::index-videocategories'))->multipart()->role('form') !!}
        @include('videos::admin.category._form')
    {!! BootForm::close() !!}

@endsection
