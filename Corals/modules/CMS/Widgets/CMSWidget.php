<?php

namespace Corals\Modules\CMS\Widgets;

use Corals\Modules\CMS\Models\Post;
use Corals\Modules\CMS\Models\Page;
use Corals\Modules\CMS\Models\Category;
use Corals\Modules\CMS\Models\News;

class CMSWidget
{

    function __construct()
    {
    }

    function run($args)
    {

        $pages = Page::count();
        $posts = Post::count();
        $news = News::count();
        $categories = Category::count();

        return '
        <div class="col-md-3 col-sm-6 col-xs-6">

          <div class="info-box  bg-aqua">
            <span class="info-box-icon "><i class="fa fa-files-o fa-fw"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">' . trans('CMS::labels.cms_widget.page') . '</span>
              <span class="info-box-number">' . $pages . '</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        
        <div class="col-md-3 col-sm-6 col-xs-6">
          <div class="info-box  bg-green">
            <span class="info-box-icon "><i class="fa fa-thumb-tack fa-fw"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">' . trans('CMS::labels.cms_widget.post') . '</span>
              <span class="info-box-number">' . $posts . '</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-6">

          <div class="info-box  bg-yellow">
            <span class="info-box-icon "><i class="fa fa fa-newspaper-o fa-fw"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">' . trans('CMS::labels.cms_widget.new') . '</span>
              <span class="info-box-number">' . $news . '</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-6">

          <div class="info-box bg-red">

            <span class="info-box-icon "><i class="fa fa-folder-open fa-fw"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">' . trans('CMS::labels.cms_widget.category') . '</span>
              <span class="info-box-number">' . $categories . '</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

';
    }

}