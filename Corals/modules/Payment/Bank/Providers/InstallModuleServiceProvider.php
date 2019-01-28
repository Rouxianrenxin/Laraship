<?php

namespace Corals\Modules\Payment\Bank\Providers;

use Carbon\Carbon;
use Corals\Foundation\Providers\BaseInstallModuleServiceProvider;

class InstallModuleServiceProvider extends BaseInstallModuleServiceProvider
{
    protected function booted()
    {
        $supported_gateways = \Payments::getAvailableGateways();

        $supported_gateways['Bank'] = 'Bank';

        \Payments::setAvailableGateways($supported_gateways);

        \DB::table('settings')->insert([
            [
                'code' => 'payment_bank_bank_information',
                'type' => 'TEXTAREA',
                'category' => 'Payment',
                'label' => 'payment_bank_bank_information',
                'value' => 'Unsere deutsche Bankverbindung:<br>
                            <br>
                            Empire Merchandising GmbH<br>
                            Volksbank Darmstadt/Deutschland<br>
                            Bankleitzahl (BLZ) 508 900 00<br>
                            Konto-Nr. 1757814<br>
                            
                            BIC: GENODEF1VBD<br>
                            IBAN: DE 0750 8900 0000 0175 7814<br>
                            <br>',
                'editable' => 1,
                'hidden' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

        ]);
    }
}
