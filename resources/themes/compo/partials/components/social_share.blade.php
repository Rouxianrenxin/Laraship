<div class="entry-share my-3"><span class="text-muted">Share:</span>
    <div class="share-links mt-2">
        <a class="social-button shape-circle sb-facebook mx-2" href="https://www.facebook.com/sharer.php?u={{ $url }}"
           onClick="openInNewWindow(this.href,this.title);"
           data-toggle="tooltip" data-placement="top" title="Facebook">
            <i class="fa fa-facebook"></i>
        </a>
        <a class="social-button shape-circle sb-twitter mx-2"
           href="https://twitter.com/share?url={{ $url }}&text={{ $title }}" data-toggle="tooltip"
           onClick="openInNewWindow(this.href,this.title);"
           data-placement="top" title="Twitter"><i class="fa fa-twitter"></i>
        </a>
        <a class="social-button shape-circle sb-pinterest mx-2"
           href="https://pinterest.com/pin/create/button/?url={{ $url }}" data-toggle="tooltip"
           onClick="openInNewWindow(this.href,this.title);"
           data-placement="top" title="Pinterest"><i class="fa fa-pinterest"></i>
        </a>
        <a class="social-button shape-circle sb-google-plus mx-2" href="https://plus.google.com/share?url={{ $url }}"
           data-toggle="tooltip"
           onClick="openInNewWindow(this.href,this.title);"
           data-placement="top" title="Google +"><i class="fa fa-google-plus"></i>
        </a>
    </div>
</div>
