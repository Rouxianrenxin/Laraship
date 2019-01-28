<?php

if (\Schema::hasTable('cms_blocks') && class_exists(\Corals\Modules\CMS\Models\Block::class)) {
    $block = \Corals\Modules\CMS\Models\Block::updateOrCreate(['name' => 'Home Features', 'key' => 'home-features'], [
        'name' => 'Home Features',
        'key' => 'home-features',
    ]);

    $widgets = array(
        array(
            'title' => 'Full Documented',
            'content' => '<div class="services-item wow fadeInRight" data-wow-delay="0.2s">
                        <div class="icon">
                            <i class="lni-book"></i>
                        </div>
                        <div class="services-content">
                            <h3><a href="#">Full Documented</a></h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quo aut magni perferendis
                                repellat rerum assumenda facere.</p>
                        </div>
                    </div>',
            'block_id' => $block->id,
            'widget_width' => 4,
            'widget_order' => 0,
            'status' => 'active',
        ),
        array(
            'title' => 'Clean & Modern Design',
            'content' => '<div class="services-item wow fadeInRight" data-wow-delay="0.4s">
                        <div class="icon">
                            <i class="lni-leaf"></i>
                        </div>
                        <div class="services-content">
                            <h3><a href="#">Clean & Modern Design</a></h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quo aut magni perferendis
                                repellat rerum assumenda facere.</p>
                        </div>
                    </div>',
            'block_id' => $block->id,
            'widget_width' => 4,
            'widget_order' => 1,
            'status' => 'active',
        ),

        array(
            'title' => 'Great Features',
            'content' => '<div class="services-item wow fadeInRight" data-wow-delay="0.6s">
                        <div class="icon">
                            <i class="lni-map"></i>
                        </div>
                        <div class="services-content">
                            <h3><a href="#">Great Features</a></h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quo aut magni perferendis
                                repellat rerum assumenda facere.</p>
                        </div>
                    </div>',
            'block_id' => $block->id,
            'widget_width' => 4,
            'widget_order' => 2,
            'status' => 'active',

        ),
        array(
            'title' => 'Completely Customizable',
            'content' => '<div class="services-item wow fadeInRight" data-wow-delay="0.8s">
                        <div class="icon">
                            <i class="lni-cog"></i>
                        </div>
                        <div class="services-content">
                            <h3><a href="#">Completely Customizable</a></h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quo aut magni perferendis
                                repellat rerum assumenda facere.</p>
                        </div>
                    </div>',
            'block_id' => $block->id,
            'widget_width' => 4,
            'widget_order' => 3,
            'status' => 'active',

        ),
        array(
            'title' => 'User Friendly',
            'content' => '<div class="services-item wow fadeInRight" data-wow-delay="1s">
                        <div class="icon">
                            <i class="lni-pointer-up"></i>
                        </div>
                        <div class="services-content">
                            <h3><a href="#">User Friendly</a></h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quo aut magni perferendis
                                repellat rerum assumenda facere.</p>
                        </div>
                    </div>',
            'block_id' => $block->id,
            'widget_width' => 4,
            'widget_order' => 4,
            'status' => 'active',

        ),
        array(
            'title' => 'Awesome Layout',
            'content' => '<div class="services-item wow fadeInRight" data-wow-delay="1.2s">
                        <div class="icon">
                            <i class="lni-layout"></i>
                        </div>
                        <div class="services-content">
                            <h3><a href="#">Awesome Layout</a></h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quo aut magni perferendis
                                repellat rerum assumenda facere.</p>
                        </div>
                    </div>',
            'block_id' => $block->id,
            'widget_width' => 4,
            'widget_order' => 5,
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


