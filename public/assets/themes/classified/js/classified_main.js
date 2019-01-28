$(document).ajaxStart(function () {
    /* Page Loader active
          ========================================================*/
    $('#preloader').show();
});

$(document).ajaxComplete(function () {
    /* Page Loader active
      ========================================================*/
    $('#preloader').fadeOut();

    //initThemeElements();
});

$(document).ready(function () {
    initThemeElements();
    
    $(".call").click(function () {
        event.preventDefault();
        $("span.phonenumber").show();
    })
});