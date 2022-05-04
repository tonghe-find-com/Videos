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
    <link rel="stylesheet" href="/project/css/wrapper.min.css" />
@endpush

@push('js')
    <!-- $$$ Single JS $$$ -->
    <!-- Go to www.addthis.com/dashboard to customize your tools -->
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5fb1eaa151398095"></script>
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
                        <li class="breadcrumb-item"><a href="{{ $model->category->url() }}">{{$model->category->title}}</a></li>
                        <li aria-current="page" class="breadcrumb-item active">{{$model->title}}</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="container wrapper-video__container">
            <div class="flexCC">
                <h1 class="heading"><i class="fas fa-film"></i>{{$model->title}}</h1>
            </div>

            <div class="block-video wow fadeIn">

                <div class="block-video__videosource">
                    <!-- 放影片元素 -->
                    @if($model->url)
                        <iframe width="800" height="600" src="https://www.youtube.com/embed/{{ $model->url }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    @endif

                    @if($model->files)
                        @foreach ($model->files as $item)
                            @if($item->type == 'a')
                            <video src="{{ $item->url }}" width="100%" height="" controls></video>
                            @endif
                        @endforeach
                    @endif

                </div>
                <div class="block-video__context">
                    {!! $model->body !!}
                </div>

            </div>
        </div>

        <div class="flexCC">
            <!-- Go to www.addthis.com/dashboard to customize your tools -->
            分享：
            <div class="addthis_inline_share_toolbox_hgaf"></div>
        </div>

        <div class="flexCC mt-xl mt-md-md-d">
            <a href="javascript:history.back()" class="btn btn-back">返回</a>
        </div>



    </div>

</section>
@endsection


