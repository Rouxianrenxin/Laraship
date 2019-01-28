<li class="nav-item @if($active_tab=="subscriptions") active @endif">
    <a class="nav-link @if($active_tab=="subscriptions") active @endif" href="#subscriptions" data-toggle="tab">
        @lang('Subscriptions::labels.subscription.my_subscription')
    </a>
</li>
<li class="nav-item @if($active_tab=="invoices") active @endif">
    <a class="nav-link @if($active_tab=="invoices") active @endif" href="#invoices" data-toggle="tab">
        @lang('Subscriptions::labels.subscription.my_invoices')
    </a>
</li>