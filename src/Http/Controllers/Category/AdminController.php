<?php

namespace TypiCMS\Modules\Videos\Http\Controllers\Category;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use TypiCMS\Modules\Core\Http\Controllers\BaseAdminController;
use TypiCMS\Modules\Videos\Exports\Export;
use TypiCMS\Modules\Videos\Http\Requests\CategoryFormRequest;
use TypiCMS\Modules\Videos\Models\Videocategory;

class AdminController extends BaseAdminController
{
    public function index(): View
    {
        return view('videos::admin.category.index');
    }

    public function export(Request $request)
    {
        $filename = date('Y-m-d').' '.config('app.name').' Videocategories.xlsx';

        return Excel::download(new Export($request), $filename);
    }

    public function create(): View
    {
        $model = new Videocategory();

        return view('videos::admin.category.create')
            ->with(compact('model'));
    }

    public function edit(Videocategory $Videocategory): View
    {
        return view('videos::admin.category.edit')
            ->with(['model' => $Videocategory]);
    }

    public function store(CategoryFormRequest $request): RedirectResponse
    {
        $Videocategory = Videocategory::create($request->validated());

        return $this->redirect($request, $Videocategory);
    }

    public function update(Videocategory $Videocategory, CategoryFormRequest $request): RedirectResponse
    {
        $Videocategory->update($request->validated());

        return $this->redirect($request, $Videocategory);
    }
}
