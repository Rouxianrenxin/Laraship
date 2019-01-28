<?php


// ReferralProgram
Breadcrumbs::register('referral_program', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(trans('ReferralProgram::module.referral_relationship.title'));
});

//ReferralProgram
Breadcrumbs::register('referral_programs', function ($breadcrumbs) {
    $breadcrumbs->parent('referral_program');
    $breadcrumbs->push(trans('ReferralProgram::module.referral_program.title'), url(config('referral_program.models.referral_program.resource_url')));
});

Breadcrumbs::register('referral_program_create_edit', function ($breadcrumbs) {
    $breadcrumbs->parent('referral_programs');
    $breadcrumbs->push(view()->shared('title_singular'));
});

Breadcrumbs::register('referral_program_show', function ($breadcrumbs) {
    $breadcrumbs->parent('referral_programs');
    $breadcrumbs->push(view()->shared('title_singular'));
});
//ReferralLinks
Breadcrumbs::register('referral_links', function ($breadcrumbs, $referral_program) {
    $breadcrumbs->parent('referral_programs');
    $breadcrumbs->push(trans('ReferralProgram::module.referral_link.name_referral_link',['name' => $referral_program->name]));
});

Breadcrumbs::register('referral_link_create_edit', function ($breadcrumbs, $referral_program) {
    $breadcrumbs->parent('referral_links', $referral_program);
    $breadcrumbs->push(view()->shared('title_singular'));
});

//ReferralLinks
Breadcrumbs::register('referral_relationships', function ($breadcrumbs, $referral_program) {
    $breadcrumbs->parent('referral_programs');

    if ($referral_program) {
        $text = trans('ReferralProgram::module.referral_relationship.name_referral_relationship',['name' => $referral_program->name]);
    } else {
        $text = trans('ReferralProgram::module.referral_relationship.relation_ship_title');
    }

    $breadcrumbs->push($text);
});
