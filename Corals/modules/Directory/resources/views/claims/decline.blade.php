<div class="row">
    <div class="col-md-12">
        {!! Form::open( ['url' => url('directory/claims/'.$claim->hashed_id.'/declined'),'method'=>'POST', 'class'=>'ajax-form','id'=>'claim-form','data-page_action'=>"closeModal",'data-table'=>'.dataTableBuilder']) !!}

        {!! CoralsForm::textarea('reasons','Directory::attributes.claim.reasons',false, '', ['rows'=>3]) !!}

        <button type="submit" class="btn btn-success ladda-button pull-right">@lang('Directory::attributes.claim.status_options.declined')
            <i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
        {!! Form::close() !!}
    </div>
</div>