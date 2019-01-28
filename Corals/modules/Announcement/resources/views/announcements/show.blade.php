<div class="container ann-white-background" id="announcement-container">
    <div id="announcement-header">
        <div class="row">
            <div class="col-md-12">
                <h4>{{ $announcement->title }}</h4>
                <hr/>
            </div>
        </div>
    </div>
    @if($announcement->image)
        <div class="row">
            <div class="col-md-5 hidden-sm hidden-xs d-none d-md-block">
                <div class="">
                    <img src="{{ $announcement->image }}" class="img-fluid img-responsive">
                </div>
            </div>
            <div class="col-md-7 col-xs-12 col-sm-12">
                <div id="announcement-body">
                    <div style="word-break: break-all;">
                        {!! $announcement->content !!}
                    </div>
                    @if($announcement->link_title && $announcement->link)
                        <div id="announcement-footer">
                            {!! \CoralsForm::link($announcement->link ,$announcement->link_title, ['id'=>'announcement_link_'.$announcement->id ,'target'=>'_blank', 'class'=>'btn btn-success btn-lg btn-block  announcement-link']) !!}

                        </div>
                    @endif
                </div>

            </div>
        </div>
    @else
        <div class="row">
            <div class="col-md-12">
                <div class="clearfix"></div>
                <div id="announcement-body" style="word-break: break-all;">
                    {!! $announcement->content !!}
                    @if($announcement->link_title && $announcement->link)
                        <div id="announcement-footer">
                            {!! \CoralsForm::link($announcement->link ,$announcement->link_title, ['id'=>'announcement_link_'.$announcement->id ,'target'=>'_blank', 'class'=>'btn btn-success btn-lg btn-block  announcement-link']) !!}

                        </div>
                    @endif
                </div>

            </div>
        </div>

    @endif
</div>
