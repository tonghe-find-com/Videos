<?php

namespace TypiCMS\Modules\Videos\Composers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Sidebar\SidebarGroup;
use Maatwebsite\Sidebar\SidebarItem;

class SidebarViewComposer
{
    public function compose(View $view)
    {
        if (!Gate::denies('read videocategories')) {
            $view->sidebar->group(__('Video Group'), function (SidebarGroup $group) {
                $group->id = 'videogroup';
                $group->weight = 28;
                $group->addItem(__('Video Pages'), function (SidebarItem $item) {
                    $item->id = 'videocategories';
                    $item->icon = config('typicms.videos.sidebar.icon');
                    $item->weight = config('typicms.videos.sidebar.weight');
                    $item->route('admin::index-videocategories');
                    $item->append('admin::create-videocategory');
                });
            });
        }

        if (!Gate::denies('read videos')) {
        $view->sidebar->group(__('Video Group'), function (SidebarGroup $group) {
            $group->id = 'videogroup';
            $group->weight = 28;
            $group->addItem(__('Video Items'), function (SidebarItem $item) {
                $item->id = 'videos';
                $item->icon = config('typicms.videos.sidebar.icon');
                $item->weight = config('typicms.videos.sidebar.weight');
                $item->route('admin::index-videos');
                $item->append('admin::create-video');
                });
            });
        }


        return;
    }
}
