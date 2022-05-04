<?php

namespace TypiCMS\Modules\Videos\Models;

use App\HasHomeList;
use TypiCMS\Modules\Videos\Presenters\ModulePresenter;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laracasts\Presenter\PresentableTrait;
use Spatie\Translatable\HasTranslations;
use TypiCMS\Modules\Core\Models\Base;
use TypiCMS\Modules\Files\Models\File;
use TypiCMS\Modules\History\Traits\Historable;
use TypiCMS\Modules\Pages\Models\PageSection;
use TypiCMS\NestableTrait;
use TypiCMS\Modules\Files\Traits\HasFiles;

class Video extends Base
{
    use HasFiles;
    use HasTranslations;
    use Historable;
    use NestableTrait;
    use PresentableTrait;
    use HasHomeList;

    protected $presenter = ModulePresenter::class;

    protected $dates = ['show_date'];

    protected $guarded = [];

    public $translatable = [
        'title',
        'status',
        'slug',
        'meta_title',
        'meta_keywords',
        'meta_description',
        'url',
        'body',
        'show_homepage'
    ];

    public function page(){
        return $this->belongsTo(Videocategory::class, 'page_id');
    }


    public function getThumbAttribute(): string
    {
        return $this->present()->image(null, 54);
    }

    public function image(): BelongsTo
    {
        return $this->belongsTo(File::class, 'image_id');
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(PageSection::class);
    }

    public function url()
    {
        return route(app()->getLocale()."::video-show",[$this->category->slug, $this->slug]);
    }

    public function category()
    {
        return $this->belongsTo(Videocategory::class,'category_id');
    }

}
