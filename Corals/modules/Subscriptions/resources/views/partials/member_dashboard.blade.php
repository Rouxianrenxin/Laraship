<div class="row">
    <div class="col-md-12">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="@if($active_tab=="dashboard") active @endif nav-item">
                    <a href="#dashboard" data-toggle="tab" class="@if($active_tab=="dashboard") active @endif nav-link">
                        <i class="fa fa-dashboard"></i> @lang('Subscriptions::labels.partial.dashboard')
                    </a>
                </li>
                @php \Actions::do_action('user_profile_tabs',user(),$active_tab) @endphp
            </ul>
            <div class="tab-content">
                <div class="tab-pane text-center @if($active_tab=="dashboard") active @endif" id="dashboard">
                    <h3>@lang('Subscriptions::labels.partial.welcome_dashboard')</h3>

                    <img class="img-responsive m-t-20"
                         style="max-width: 90%; margin: 0 auto; display: block;"
                         src="{{ \Settings::get('site_logo') }}">

                    <i class="fa fa-diamond m-t-20 m-b-20"
                       style="color:#7777770f; font-size: 10em;"></i>
                </div>
                @php \Actions::do_action('user_profile_tabs_content',user(),$active_tab) @endphp

            </div>
        </div>
    </div>
</div>