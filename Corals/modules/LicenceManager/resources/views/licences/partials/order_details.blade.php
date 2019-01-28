<h3>
    @lang('LicenceManager::module.licence.title')
</h3>
<div class="table-responsive">
    <table class="table color-table info-table table table-hover table-striped table-condensed">
        <thead>
        <tr>
            <th>@lang('LicenceManager::attributes.licence.code')</th>
            <th>@lang('LicenceManager::attributes.licence.product')</th>
            <th>@lang('LicenceManager::attributes.licence.expiration_date')</th>
        </tr>
        </thead>
        <tbody>
        @foreach($licences as $licence)
            <tr>
                <td>{{ $licence->code }}</td>
                <td>{!! $licence->presenter()['licenceable'] !!}</td>
                <td>{{ $licence->presenter()['expiration_date'] }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
