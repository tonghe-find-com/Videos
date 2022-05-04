<?php

namespace TypiCMS\Modules\Videos\Http\Controllers\Item;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use TypiCMS\Modules\Core\Filters\FilterOr;
use TypiCMS\Modules\Core\Http\Controllers\BaseApiController;
use TypiCMS\Modules\Videos\Models\Video;


class ApiController extends BaseApiController
{
    public function index( Request $request): LengthAwarePaginator
    {
        $data = QueryBuilder::for(Video::class)
        ->selectFields($request->input('fields.videos'))
        ->allowedSorts(['status_translated','show_date', 'title_translated','position'])
        ->allowedFilters([
            AllowedFilter::custom('title', new FilterOr()),
        ])
        ->allowedIncludes(['image'])
        ->paginate($request->input('per_page'));

        return $data;
    }

    protected function updatePartial( Video $item, Request $request)
    {
        foreach ($request->only('status','position') as $key => $content) {
            if ($item->isTranslatableAttribute($key)) {
                foreach ($content as $lang => $value) {
                    $item->setTranslation($key, $lang, $value);
                }
            } else {
                $item->{$key} = $content;
            }
        }

        $item->save();
    }
    public function sort(Request $request)
    {
        $data = $request->only('moved', 'item');
        foreach ($data['item'] as $position => $item) {
            $page = Video::find($item['id']);

            $sortData = [
                'position' => (int) $position + 1,
            ];

            $page->update($sortData);
        }
    }
    public function destroy(Video $item)
    {
        $item->delete();
    }
}
