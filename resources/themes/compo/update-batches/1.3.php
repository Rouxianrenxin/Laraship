<?php

if (\Schema::hasTable('cms_blocks') && class_exists(\Corals\Modules\CMS\Models\Block::class)) {
    $block = \Corals\Modules\CMS\Models\Block::updateOrCreate(['name' => 'Testimonial', 'key' => 'testimonial'], [
        'name' => 'Testimonial',
        'key' => 'testimonial',
    ]);

    $widgets = array(
        array(
            'title' => 'Testimonial 1',
            'content' => '<div class="testimonial-card">
    <div class="head">
        <img src="/assets/themes/compo/images/parent-1.jpg" class="rounded-circle testimonial-img"
             alt="">
    </div>
    <div class="body">
        <p class="testimonial-text">We\'re very happy with the laraship. There are an amazing team
            behind this big platform.</p>
        <p>
            <i class="text-primary bold">Mr. Dereck</i>
            <small class="text-muted">, Shop owner</small>
        </p>
    </div>
</div>',
            'block_id' => $block->id,
            'widget_width' => 6,
            'widget_order' => 0,
            'status' => 'active',
        ),
        array(
            'title' => 'Testimonial 2',
            'content' => '<div class="testimonial-card">
    <div class="head">
        <img src="/assets/themes/compo/images/parent-2.jpg" class="rounded-circle testimonial-img"
             alt="">
    </div>
    <div class="body">
        <p class="testimonial-text">We\'re very happy with the laraship. There are an amazing team
            behind this big platform.</p>
        <p>
            <i class="text-primary bold">Ms. Lois</i>
            <small class="text-muted">, Developer</small>
        </p>
    </div>
</div>',
            'block_id' => $block->id,
            'widget_width' => 6,
            'widget_order' => 1,
            'status' => 'active',
        ),
        array(
            'title' => 'Testimonial 3',
            'content' => '<div class="testimonial-card">
    <div class="head">
        <img src="/assets/themes/compo/images/parent-3.jpg" class="rounded-circle testimonial-img"
             alt="">
    </div>
    <div class="body">
        <p class="testimonial-text">We\'re very happy with the laraship. There are an amazing team
            behind this big platform.</p>
        <p>
            <i class="text-primary bold">Mr. David</i>
            <small class="text-muted">, Business Manager</small>
        </p>
    </div>
</div>',
            'block_id' => $block->id,
            'widget_width' => 6,
            'widget_order' => 2,
            'status' => 'active',
        ),
        array(
            'title' => 'Testimonial 4',
            'content' => '<div class="testimonial-card">
    <div class="head">
        <img src="/assets/themes/compo/images/parent-1.jpg" class="rounded-circle testimonial-img"
             alt="">
    </div>
    <div class="body">
        <p class="testimonial-text">We\'re very happy with the laraship. There are an amazing team
            behind this big platform.</p>
        <p>
            <i class="text-primary bold">Ms. Richard</i>
            <small class="text-muted">, Product Manager</small>
        </p>
    </div>
</div>',
            'block_id' => $block->id,
            'widget_width' => 6,
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


