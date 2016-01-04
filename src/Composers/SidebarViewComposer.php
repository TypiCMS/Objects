<?php

namespace TypiCMS\Modules\Objects\Composers;

use Illuminate\Contracts\View\View;
use Maatwebsite\Sidebar\SidebarGroup;
use Maatwebsite\Sidebar\SidebarItem;
use TypiCMS\Modules\Core\Composers\BaseSidebarViewComposer;

class SidebarViewComposer extends BaseSidebarViewComposer
{
    public function compose(View $view)
    {
        $view->sidebar->group(trans('global.menus.content'), function (SidebarGroup $group) {
            $group->addItem(trans('objects::global.name'), function (SidebarItem $item) {
                $item->icon = config('typicms.objects.sidebar.icon');
                $item->weight = config('typicms.objects.sidebar.weight');
                $item->route('admin.objects.index');
                $item->append('admin.objects.create');
                $item->authorize(
                    $this->auth->hasAccess('objects.index')
                );
            });
        });
    }
}
