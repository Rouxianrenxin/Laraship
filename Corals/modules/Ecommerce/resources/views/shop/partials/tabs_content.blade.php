<div class="tab-pane @if($active_tab=="orders") active @endif" id="orders">
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive m-t-10"
                 style="min-height: 235px;padding-bottom: 20px;">
                {!! $dataTable->table(['class' => 'color-table info-table table table-hover table-striped table-condensed','style'=>'width:100%;']) !!}
            </div>
        </div>
    </div>
</div>

