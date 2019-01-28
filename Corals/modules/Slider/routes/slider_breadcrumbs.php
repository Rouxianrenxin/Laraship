<?php


// CMS
Breadcrumbs::register('slider', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(trans('Slider::module.slider.title_singular'));
});


//Slider
Breadcrumbs::register('sliders', function ($breadcrumbs) {
    $breadcrumbs->parent('slider');
    $breadcrumbs->push(trans('Slider::module.slider.title'), url(config('slider.models.slider.resource_url')));
});

Breadcrumbs::register('slider_create_edit', function ($breadcrumbs) {
    $breadcrumbs->parent('sliders');
    $breadcrumbs->push(view()->shared('title_singular'));
});

Breadcrumbs::register('slider_show', function ($breadcrumbs) {
    $breadcrumbs->parent('sliders');
    $breadcrumbs->push(view()->shared('title_singular'));
});
//Slides
Breadcrumbs::register('slides', function ($breadcrumbs, $slider) {
    $breadcrumbs->parent('sliders');
    $breadcrumbs->push(trans('Slider::module.slide.slide_name',['slider' => $slider->name]), route(config('slider.models.slide.resource_route'), ['slider' => $slider->hashed_id]));
});

Breadcrumbs::register('slide_create_edit', function ($breadcrumbs, $slider) {
    $breadcrumbs->parent('slides', $slider);
    $breadcrumbs->push(view()->shared('title_singular'));
});

Breadcrumbs::register('slide_show', function ($breadcrumbs, $slider) {
    $breadcrumbs->parent('slides', $slider);
    $breadcrumbs->push(view()->shared('title_singular'));
});
