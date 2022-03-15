<?php

namespace TypiCMS\Modules\Objects\Composers;

use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Maatwebsite\Sidebar\SidebarGroup;
use Maatwebsite\Sidebar\SidebarItem;

class SidebarViewComposer
{
    public function compose(View $view)
    {
        if (Gate::denies('read objects')) {
            return;
        }
        $view->sidebar->group(__('Content'), function (SidebarGroup $group) {
            $group->id = 'content';
            $group->weight = 30;
            $group->addItem(__('Objects'), function (SidebarItem $item) {
                $item->id = 'objects';
                $item->icon = config('typicms.modules.objects.sidebar.icon');
                $item->weight = config('typicms.modules.objects.sidebar.weight');
                $item->route('admin::index-objects');
                $item->append('admin::create-object');
            });
        });
    }
}
