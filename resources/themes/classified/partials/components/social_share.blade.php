
<div class="social-link">
    <a class="facebook" href="https://www.facebook.com/sharer.php?u={{ $url }}"
       onClick="openInNewWindow(this.href,this.title);"
       data-toggle="tooltip" data-placement="top" title="Facebook">
        <i class="lni-facebook-filled"></i>
    </a>
    <a class="twitter"
       href="https://twitter.com/share?url={{ $url }}&text={{ $title }}" data-toggle="tooltip"
       onClick="openInNewWindow(this.href,this.title);"
       data-placement="top" title="Twitter"><i class="lni-twitter-filled"></i>
    </a>
    <a class="linkedin"
       href="https://pinterest.com/pin/create/button/?url={{ $url }}" data-toggle="tooltip"
       onClick="openInNewWindow(this.href,this.title);"
       data-placement="top" title="Pinterest"><i class="lni-linkedin-fill"></i>
    </a>
    <a class="google" href="https://plus.google.com/share?url={{ $url }}"
       data-toggle="tooltip"
       onClick="openInNewWindow(this.href,this.title);"
       data-placement="top" title="Google +"><i class="lni-google-plus"></i>
    </a>
</div>

