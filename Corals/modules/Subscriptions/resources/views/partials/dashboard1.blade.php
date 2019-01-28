<div class="row m-b-10">
    <div class="col-lg-3 col-xs-6">
        @widget('subscriptions')
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        @widget('plans')
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        @widget('new_users',['days'=>30])
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        @widget('revenue')

    </div>
    <!-- ./col -->
</div>

