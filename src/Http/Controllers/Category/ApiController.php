<?php

namespace TypiCMS\Modules\Videos\Http\Controllers\Category;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use TypiCMS\Modules\Core\Filters\FilterOr;
use TypiCMS\Modules\Core\Http\Controllers\BaseApiController;
use TypiCMS\Modules\Videos\Models\Videocategory;

class ApiController extends BaseApiController
{
    public function index(Request $request): LengthAwarePaginator
    {
        $data = QueryBuilder::for(Videocategory::class)
            ->selectFields($request->input('fields.videocategories'))
            ->allowedSorts(['status_translated', 'title_translated','position'])
            ->allowedFilters([
                AllowedFilter::custom('title', new FilterOr()),
            ])
            ->allowedIncludes(['image'])
            ->paginate($request->input('per_page'));

        return $data;
    }

    protected function updatePartial(Videocategory $Videocategory, Request $request)
    {
        foreach ($request->only('status','position') as $key => $content) {
            if ($Videocategory->isTranslatableAttribute($key)) {
                foreach ($content as $lang => $value) {
                    $Videocategory->setTranslation($key, $lang, $value);
                }
            } else {
                $Videocategory->{$key} = $content;
            }
        }

        $Videocategory->save();
    }

    public function destroy(Videocategory $Videocategory)
    {
        if($Videocategory->items->count() == 0){
            $Videocategory->delete();
        }else{
            return response(['message' => 'This item cannot be deleted because it has children.'], 403);
        }
    }
}
