<?php

return [
    'feature' => [
        'index_title' => '[:name] :title',
        'feature_record_success' => 'Features have been reordered successfully',
        'no_change' => 'No Changes were made',
        'plan' => '<i class="fa fa-fw fa-puzzle-piece"></i> Plans',
        'can_drop_table_row' => 'You can drag/drop table rows to reorder the features in pricing table.',
        'label_feature' => ':count_feature Features ',
    ],
    'plan' => [
        'index_title' => '[:name] :title',
        'feature_required' => 'Feature values are required',
        'bill' => 'Bill',
        'bill_cycle' => 'e.g. Bill cycle will be every 2 Months',
        'product_name_does_net_feature' => ' [:name] doesn\'t have features.',
        'add_feature' => '<i class="fa fa-plus"></i> Add feature to [:name]',
        'features' => '<i class="fa fa-fw fa-star"></i> Features',
    ],
    'subscription' => [
        'subscription_name_success' => 'Your subscription to <b>:name</b> plan has been cancelled successfully.',
        'access_account_till_end' => 'you can access your account till the end of this subscription period',
        'subscription_request_received' => 'Your subscription request has been received, and it will be activated when payment acquired',
        'you_have_subscribed_success' => 'You have been subscribed successfully to <b>:name</b> plan',
        'create_invoice' => 'Create Invoice for Subscription  [:name]',
        'payment_are_missing' => 'Payment details are missing',
        'payment_configuration' => '<i class="fa fa-credit-card"></i> Payment Configuration',
        'add_new_subscription' => '<i class="fa fa-plus"></i> Add new Subscription',
        'active_subscriptions' => 'Active Subscriptions',
        'you_have_cancelled_subscription' => 'You have cancelled your subscription and it\'s ending on',
        'billing_details' => 'Billing Details',
        'shipping_details' => 'Shipping Details',
        'start_subscription_now' => 'Start Your Subscription Now.
                                <br/>
                                just click on (<i class="fa fa-plus"></i> Add new Subscription)
                                button',
        'pending_subscription' => ' <i class="fa fa-click"></i> Pending Subscriptions',
        'subscription_not_approved' => ' <b>Your Subscription is not approved yet</b>',
        'my_subscription' => '<i class="fa fa-diamond"></i> My Subscriptions',
        'my_invoices' => '<i class="fa fa-file-text-o"></i> My Invoices',
        'invoices' => 'Invoices',
        'checkout_details' => 'Checkout Details',
        'subscription_details' => 'Subscription Details',
        'address_details' => 'Address Details',
        'payment_details' => 'Payment Details',
        'subscribe' => 'Subscribe',
        'check_out' => '<i class="fa fa-check"></i> Checkout',
        'continue' => '<i class="fa fa-check"></i> Continue',
        'avoid_data_inconsistency' => 'To avoid data inconsistency with the remote gateway, editing subscription manually is not
                    recommended, and changes need to be reflected the remote gateway manually.',
        'update_payment_details' => ' Update Payment Details',
        'save' => '<i class="fa fa-cart"></i> Save ',
        'select_payment_method' => 'Please select Payment method',
        'create_invoice_label' => '<i class="fa fa-fw fa-plus"></i> Create Invoice',

    ],
    'product' => [
        'plan' => ' :count_plan Plans ',

    ],
    'subscription_request' => [
        'next_billing_date_field' => 'Next billing date field is required when payment is offline and subscription is active',
    ],
    'partial' => [
        'dashboard' => 'Dashboard',
        'welcome_dashboard' => 'Welcome to your Dashboard',
        'subscription' => 'Subscriptions',
        'not_subscribed' => 'Not Subscribed Yet'
    ],
    'widget' => [
        'plan' => 'Plans',
        'subscription' => 'Subscriptions',
        'more_info' => 'More info <i class="fa fa-arrow-circle-right"></i>',
    ]
];