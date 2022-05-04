@extends('core::admin.master')

@section('title', __('New Video'))

@section('content')

    <div class="header">
        @include('core::admin._button-back', ['module' => 'videos'])
        <h1 class="header-title">@lang('New Video')</h1>
    </div>

    {!! BootForm::open()->action(route('admin::store-video'))->multipart() !!}
        @include('videos::admin.item._form')
    {!! BootForm::close() !!}

@endsection
