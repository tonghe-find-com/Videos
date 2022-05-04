<?php

namespace TypiCMS\Modules\Videos\Facades;

use Illuminate\Support\Facades\Facade;

class Videos extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Videos';
    }
}
