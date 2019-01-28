<?php

namespace Corals\Menu\Transformers;

use Corals\Foundation\Transformers\BaseTransformer;
use Corals\Menu\Models\Menu;

class MenuTransformer extends BaseTransformer
{
    public function __construct()
    {
        $this->resource_url = config('menu.models.menu.resource_url');

        parent::__construct();
    }

    /**
     * @param Menu $menu
     * @return array
     * @throws \Throwable
     */
    public function transform(Menu $menu)
    {
        $item_actions = [
            'create' => [
                'icon' => 'fa fa-fw fa-plus',
                'href' => url($this->resource_url . '/create?parent=' . $menu->hashed_id),
                'label' => trans('Menu::labels.create_sub'),
                'data' => [
                    'action' => 'load',
                    'load_to' => '#menu_form'
                ]
            ],
            'edit' => [
                'href' => url($this->resource_url . '/' . $menu->hashed_id . '/edit'),
                'label' => trans('Corals::labels.edit'),
                'data' => [
                    'action' => 'load',
                    'load_to' => '#menu_form'
                ]
            ],
            'delete' => [
                'href' => url($this->resource_url . '/' . $menu->hashed_id),
                'label' => trans('Corals::labels.delete'),
                'data' => [
                    'action' => 'delete',
                    'page_action' => 'site_reload'
                ]
            ],
            'toggle' => [
                'icon' => 'fa fa-fw fa-flag-o',
                'href' => url($this->resource_url . '/' . $menu->hashed_id . '/toggle-status'),
                'label' => trans('Menu::labels.toggle_status'),
                'data' => [
                    'action' => 'post',
                    'page_action' => 'site_reload'
                ]
            ],
        ];

        return [
            'id' => $menu->id,
            'created_at' => format_date($menu->created_at),
            'updated_at' => format_date($menu->updated_at),
            'action' => $this->actions($menu, $item_actions)
        ];
    }
}