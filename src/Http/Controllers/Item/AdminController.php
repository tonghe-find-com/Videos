<?php

namespace TypiCMS\Modules\Videos\Http\Controllers\Item;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use TypiCMS\Modules\Core\Http\Controllers\BaseAdminController;
use TypiCMS\Modules\Videos\Models\Videocategory;
use TypiCMS\Modules\Videos\Models\Video;
use TypiCMS\Modules\Videos\Http\Requests\FormRequest;

class AdminController extends BaseAdminController
{
    public function index(): View
    {
        return view('videos::admin.item.index');
    }

    public function create()
    {
        if(Videocategory::all()->count()==0){
            return redirect()->back()->with('error','請先新增分類');
        }
        $model = new Video();

        return view('videos::admin.item.create')
            ->with(compact('model'));
    }

    public function edit( Video $item): View
    {
        return view('videos::admin.item.edit')
            ->with([
                'model' => $item,
            ]);
    }
    //建立透過此函式離開
    public function store(FormRequest $request): RedirectResponse
    {
        $item = Video::create($request->validated());

        return $this->redirect($request, $item);
    }

    //儲存、儲存並離開都是透過此函式離開
    public function update(Video $item,FormRequest $request): RedirectResponse
    {
        $item->update($request->validated());

        return $this->redirect($request, $item);
    }
}
