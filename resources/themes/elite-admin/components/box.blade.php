<!-- Default box -->
<div class="card {{ $box_class??'' }}">
    <div class="card-header with-border" style="{{ empty($box_title) && empty($box_actions)?'display:none;':'' }}">
        <div class="float-left">
            {{ $box_title or '' }}
        </div>
        <div class="card-tools float-right">
            {{ $box_actions or '' }}
        </div>
    </div>
    <div class="card-body">
        {{ $slot }}
    </div>
    <!-- /.box-body -->
    <div class="card-footer" style="{{ empty($box_footer)?'display:none;':'' }}">
        {{ $box_footer or '' }}
    </div>
    <!-- /.box-footer-->
</div>
<!-- /.box -->