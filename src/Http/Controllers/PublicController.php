<?php

namespace TypiCMS\Modules\Videos\Http\Controllers;

use Illuminate\View\View;
use TypiCMS\Modules\Core\Http\Controllers\BasePublicController;
use TypiCMS\Modules\Videos\Models\Videocategory;
use TypiCMS\Modules\Videos\Models\Video;
use Illuminate\Http\Request;

class PublicController extends BasePublicController
{
    public function index()
    {
        $model = null;
        $list = Video::published()->get();

        return view('videos::public.index')
            ->with(compact('model', 'list'));
    }

    public function category($slug,Request $request): View
    {
        $model = Videocategory::published()->whereSlugIs($slug)->firstOrFail();
        $list = Video::published()->where('category_id',$model->id)->get();

        return view('videos::public.index')
            ->with(compact('model', 'list'));
    }

    public function show($categorySlug, $slug,Request $request): View
    {
        $model = Video::published()->whereSlugIs($slug)->firstOrFail();

        return view('videos::public.show')
            ->with(compact('model'));
    }
}
