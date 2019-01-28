<?php

\DB::table('settings')->insert([
    [
        'code' => 'classified_messaging_is_enable',
        'type' => 'BOOLEAN',
        'category' => 'Classified',
        'label' => 'Enable Internal Messaging',
        'value' => 'true',
        'editable' => 1,
        'hidden' => 0,
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => \Carbon\Carbon::now(),
    ],
]);
