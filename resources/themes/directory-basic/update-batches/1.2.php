<?php


$topMenu = Corals\Menu\Models\Menu::where('key', 'frontend_top')->first();

if ($topMenu) {
    $topMenuId = $topMenu->id;

    Corals\Menu\Models\Menu::updateOrCreate([
        'parent_id' => $topMenuId,
        'key' => null,
        'url' => 'faqs',
        'active_menu_url' => 'faqs',
        'name' => 'FAQs',
        'description' => 'FAQs',
        'icon' => null,
        'target' => null,
        'order' => 970
    ]);
}


