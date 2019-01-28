<div class="entry-share mt-2 mb-2 ">
    <div class="share-links">
        <a class="social-button shape-rounded sb-facebook" href="https://www.facebook.com/sharer.php?u={{ $url }}"
           onClick="openInNewWindow(this.href,this.title);"
           data-toggle="tooltip" data-placement="top" title="Facebook">
            <i class="socicon-facebook"></i>
        </a>
        <a class="social-button shape-rounded sb-twitter"
           href="https://twitter.com/share?url={{ $url }}&text={{ $title }}" data-toggle="tooltip"
           onClick="openInNewWindow(this.href,this.title);"
           data-placement="top" title="Twitter"><i class="socicon-twitter"></i>
        </a>
        <a class="social-button shape-rounded sb-pinterest"
           href="https://pinterest.com/pin/create/button/?url={{ $url }}" data-toggle="tooltip"
           onClick="openInNewWindow(this.href,this.title);"
           data-placement="top" title="Pinterest"><i class="socicon-pinterest"></i>
        </a>
        <a class="social-button shape-rounded sb-google-plus" href="https://plus.google.com/share?url={{ $url }}"
           data-toggle="tooltip"
           onClick="openInNewWindow(this.href,this.title);"
           data-placement="top" title="Google +"><i class="socicon-googleplus"></i>
        </a>
    </div>
</div>
