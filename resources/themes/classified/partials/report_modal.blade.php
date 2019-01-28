<div class="modal fade" id="ProductReportModal" tabindex="-1" role="dialog"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            {!! Form::open( ['url' => url('products/'.$product->hashed_id.'/report'),'method'=>'POST', 'class'=>'ajax-form','id'=>'report-form','data-page_action'=>"closeModal"]) !!}

            <div class="modal-header">
                <h5 class="modal-title">Report {{$product->name}} Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {!! CoralsForm::text('name','corals-classified-master::labels.partial.component.report.name',true, user() ? user()->name : "", []) !!}
                {!! CoralsForm::text('email','corals-classified-master::labels.partial.component.report.email',true, user() ? user()->email : "", []) !!}
                {!! CoralsForm::textarea('report_body','corals-classified-master::labels.partial.component.report.body',true, '', ['rows'=>5]) !!}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"
                        data-dismiss="modal">@lang('corals-classified-master::labels.partial.component.report.close')</button>
                <button type="submit" class="btn btn-primary"
                        style="background:#00BCD4;">@lang('corals-classified-master::labels.partial.component.report.send')</button>
            </div>
            {!! Form::close() !!}

        </div>
    </div>
</div>