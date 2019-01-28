<?php

if (\Schema::hasTable('cms_blocks') && class_exists(\Corals\Modules\CMS\Models\Block::class)) {
    $block = \Corals\Modules\CMS\Models\Block::updateOrCreate(['name' => 'Home Stores Features', 'key' => 'home-stores-features'], [
        'name' => 'Home Stores Features',
        'key' => 'home-stores-features',
    ]);

    $widgets = array(
        array(
            'title' => 'Free Worldwide Shipping',
            'content' => '<div class="text-center mb-30"><img
                        class="d-block w-90 img-thumbnail rounded-circle mx-auto mb-3"
                        src="/assets/themes/ecommerce-basic/img/services/01.png"
                        alt="Shipping">
                <h6>Free Worldwide Shipping</h6>
                <p class="text-muted margin-bottom-none">Free shipping for all orders over $100</p>
            </div>',
            'block_id' => $block->id,
            'widget_width' => 3,
            'widget_order' => 0,
            'status' => 'active',
        ),
        array(
            'title' => 'Money Back Guarantee',
            'content' => '<div class="text-center mb-30"><img
                        class="d-block w-90 img-thumbnail rounded-circle mx-auto mb-3"
                        src="/assets/themes/ecommerce-basic/img/services/02.png"
                        alt="Money Back">
                <h6>Money Back Guarantee</h6>
                <p class="text-muted margin-bottom-none">We return money within 30 days</p>
            </div>',
            'block_id' => $block->id,
            'widget_width' => 3,
            'widget_order' => 1,
            'status' => 'active',
        ),

        array(
            'title' => '24/7 Customer Support',
            'content' => '<div class="text-center mb-30"><img
                        class="d-block w-90 img-thumbnail rounded-circle mx-auto mb-3"
                        src="/assets/themes/ecommerce-basic/img/services/03.png"
                        alt="Support">
                <h6>24/7 Customer Support</h6>
                <p class="text-muted margin-bottom-none">Friendly 24/7 customer support</p>
            </div>',
            'block_id' => $block->id,
            'widget_width' => 3,
            'widget_order' => 2,
            'status' => 'active',

        ),
        array(
            'title' => 'Secure Online Payment',
            'content' => '<div class="text-center mb-30"><img
                        class="d-block w-90 img-thumbnail rounded-circle mx-auto mb-3"
                        src="/assets/themes/ecommerce-basic/img/services/04.png"
                        alt="Payment">
                <h6>Secure Online Payment</h6>
                <p class="text-muted margin-bottom-none">We posess SSL / Secure Certificate</p>
            </div>',
            'block_id' => $block->id,
            'widget_width' => 3,
            'widget_order' => 3,
            'status' => 'active',

        ),
    );
    foreach ($widgets as $widget) {
        \Corals\Modules\CMS\Models\Widget::updateOrCreate(
            ['block_id' => $widget['block_id'], 'title' => $widget['title']],
            $widget
        );
    }
}

$topMenu = Corals\Menu\Models\Menu::updateOrCreate(['key' => 'frontend_top'], [
    'parent_id' => 0,
    'url' => null,
    'name' => 'Frontend Top',
    'description' => 'Frontend Top Menu',
    'icon' => null,
    'target' => null,
    'order' => 0
]);

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

