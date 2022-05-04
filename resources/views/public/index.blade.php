@extends('pages::public.master')

@isset($model)
    @section('title',$model->meta_title==""?$model->title:$model->meta_title)
    @section('keywords',$model->meta_keywords)
    @section('description',$model->meta_description)
@else
    @section('title',$page->meta_title==""?$page->title:$page->meta_title)
    @section('keywords',$page->meta_keywords)
    @section('description',$page->meta_description)
@endisset



@push('css')
    <!-- $$$ Single CSS $$$ -->
    <link rel="stylesheet" href="{{ asset('project/css/wrapper.min.css') }}" />
@endpush

@push('js')
    <!-- $$$ Single JS $$$ -->
    <script>
        $currentpage = "NEWS"
    </script>
@endpush

@push('banner')
    @include('template.banner')
@endpush

@section('content')
<section>

    <div class="wrapper-B wrapper-video">
        <div class="wrapper-B__ball1"></div>
        <div class="wrapper-B__ball2"></div>
        <div class="container">
            <div class="flexLC mb-md-sm-d mb-lg">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ TypiCMS::homeUrl() }}">{{ Pages::getHomeTitle() }}</a></li>
                        <li aria-current="page" class="breadcrumb-item active">{{$model->title ?? $page->title}}</li>
                    </ol>
                </nav>
            </div>
            <div class="flexCC">
                <h1 class="heading"><i class="fas fa-film"></i>{{$model->title ?? $page->title}}</h1>
            </div>
            <div class="flexCC mt-lg wow fadeIn">
                <div class="itemcate-group">
                    <a href="{{$page->url()}}" class="itemcate @if(!$model) itemcate--all @endif">全部</a>
                    @foreach (Videocategories::list() as $item)
                    <a href="{{ $item->url() }}" class="itemcate @if($model && $model->id == $item->id) itemcate--now @endif">{{$item->title}}</a>
                    @endforeach
                </div>
            </div>

            <div class="videobox-group">
                @foreach ($list as $item)
                <a href="{{ $item->url() }}" class="videobox">
                    <div class="videobox__pic" style="background-image: url('{{ $item->present()->image() }}')">
                        <div class="videobox__date">{{ $item->show_date->format('Y/m/d') }}</div>
                    </div>
                    <h2 class="videobox__title">{{$item->title}}</h2>
                </a>
                @endforeach
            </div>







        </div>

    </div>

</section>
@endsection


