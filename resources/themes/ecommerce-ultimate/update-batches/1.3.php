<?php

if (\Schema::hasTable('cms_blocks') && class_exists(\Corals\Modules\CMS\Models\Block::class)) {
    $block = \Corals\Modules\CMS\Models\Block::updateOrCreate(['name' => 'Home Stores Features', 'key' => 'home-stores-features'], [
        'name' => 'Home Stores Features',
        'key' => 'home-stores-features',
    ]);

    $block1 = \Corals\Modules\CMS\Models\Block::updateOrCreate(['name' => 'Home Offers', 'key' => 'home-offers'], [
        'name' => 'Home Offers',
        'key' => 'home-offers',
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
        array(
            'title' => 'Home Page Offer',
            'content' => '<section class="fw-section padding-top-2x padding-bottom-8x"
             style="background-image: url(/assets/themes/ecommerce-ultimate/img/background.jpg);"><span
                class="overlay" style="opacity: .5;"></span>
        <div class="container text-center">
            <div class="d-inline-block bg-danger text-white text-lg py-2 px-3 rounded">Limited Time Offer</div>
            <div class="pt-5"></div>
            <div class="countdown countdown-inverse" data-date-time="07/30/2018 12:00:00">
                <div class="item">
                    <div class="days">00</div>
                    <span class="days_ref">Days</span>
                </div>
                <div class="item">
                    <div class="hours">00</div>
                    <span class="hours_ref">Hours</span>
                </div>
                <div class="item">
                    <div class="minutes">00</div>
                    <span class="minutes_ref">Mins</span>
                </div>
                <div class="item">
                    <div class="seconds">00</div>
                    <span class="seconds_ref">Secs</span>
                </div>
            </div>
        </div>
    </section>
    <a class="d-block position-relative mx-auto" href="{{url(\'shop\')}}"
       style="max-width: 682px; margin-top: -185px; z-index: 10;">
        <img class="d-block w-100" src="/assets/themes/ecommerce-ultimate/img/shop/products/bag.png" alt=""
             style="width: 200px!important;margin: 0 auto;">
    </a>',
            'block_id' => $block1->id,
            'widget_width' => 12,
            'widget_order' => 0,
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


