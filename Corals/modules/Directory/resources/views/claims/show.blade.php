<div class="row">
    <div class="col-md-12">
        <h4><b>@lang('Directory::attributes.claim.requester')</b></h4>
        <p>
            {!! $claim->present('requester') !!}
        </p>
    </div>
</div>
<div class="row">
    <div class="col-md-2">
        <h4><b>@lang('Corals::attributes.status')</b></h4>
        <p>
            {!! $claim->present('status') !!}
        </p>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <h4><b>@lang('Directory::attributes.claim.brief_desctiption')</b></h4>
        <p>
            {!! $claim->present('brief_desctiption') !!}
        </p>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <h4><b>@lang('Directory::attributes.claim.file')</b></h4>
        <p>
            {!! $claim->present('file') !!}
        </p>
    </div>
</div>


