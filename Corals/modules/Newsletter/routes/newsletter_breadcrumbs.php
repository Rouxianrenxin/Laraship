<?php

//News Litters

Breadcrumbs::register('newsletter', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(trans('Newsletter::module.newsletter.title'));
});

//MailList
Breadcrumbs::register('mail_lists', function ($breadcrumbs) {
    $breadcrumbs->parent('newsletter');
    $breadcrumbs->push(trans('Newsletter::module.mail_list.title'), url(config('newsletter.models.mail_list.resource_url')));
});

Breadcrumbs::register('mail_list_create_edit', function ($breadcrumbs) {
    $breadcrumbs->parent('mail_lists');
    $breadcrumbs->push(view()->shared('title_singular'));
});

Breadcrumbs::register('mail_list_show', function ($breadcrumbs) {
    $breadcrumbs->parent('mail_lists');
    $breadcrumbs->push(view()->shared('title_singular'));
});


//Subscriber
Breadcrumbs::register('subscribers', function ($breadcrumbs) {
    $breadcrumbs->parent('newsletter');
    $breadcrumbs->push(trans('Newsletter::module.subscriber.title'), url(config('newsletter.models.subscriber.resource_url')));
});

Breadcrumbs::register('subscriber_create_edit', function ($breadcrumbs) {
    $breadcrumbs->parent('subscribers');
    $breadcrumbs->push(view()->shared('title_singular'));
});

Breadcrumbs::register('subscriber_show', function ($breadcrumbs) {
    $breadcrumbs->parent('subscribers');
    $breadcrumbs->push(view()->shared('title_singular'));
});


//Email
Breadcrumbs::register('emails', function ($breadcrumbs) {
    $breadcrumbs->parent('newsletter');
    $breadcrumbs->push(trans('Newsletter::module.email.title'), url(config('newsletter.models.email.resource_url')));
});

Breadcrumbs::register('email_create_edit', function ($breadcrumbs) {
    $breadcrumbs->parent('emails');
    $breadcrumbs->push(view()->shared('title_singular'));
});

Breadcrumbs::register('email_show', function ($breadcrumbs) {
    $breadcrumbs->parent('emails');
    $breadcrumbs->push(view()->shared('title_singular'));
});

