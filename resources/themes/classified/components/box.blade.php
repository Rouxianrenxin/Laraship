<!-- Default box -->
<div class="box {{ $box_class??'' }}">
    <div class="box-header with-border {{ empty($box_title) && empty($box_actions)?'hidden':'' }}">
        <h3 class="box-title {{ !empty($box_title) || !empty($box_actions)?'':'hidden' }}">{{ $box_title or '' }}</h3>

        <div class="box-tools pull-right">
            {{ $box_actions or '' }}
        </div>
    </div>
    <div class="box-body">
        {{ $slot }}
    </div>
    <!-- /.box-body -->
    <div class="box-footer {{ !empty($box_footer)?'':'hidden' }}">{{ $box_footer or '' }}</div>
    <!-- /.box-footer-->
</div>
<!-- /.box -->