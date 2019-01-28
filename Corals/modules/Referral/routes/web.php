<?php

Route::group(['prefix' => 'referral'], function () {
    Route::get('referral-programs/get-action-view/{action}/{edit_mode}/{referral_program?}', 'ReferralProgramsController@getActionView');
    Route::resource('referral-programs', 'ReferralProgramsController');

    Route::resource('referral-programs.referral-links', 'ReferralLinksController', ['only' => ['index', 'create', 'store']]);
    Route::resource('referral-programs.referral-relationships', 'ReferralRelationshipsController', ['only' => ['index', 'destroy']]);
    Route::get('my-referrals', 'ReferralRelationshipsController@getUserReferrals');
});