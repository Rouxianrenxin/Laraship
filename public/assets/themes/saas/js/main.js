$(document).ready(function () {
    initThemeElements();
});

$('body').on('click', '[data-action]', function (e) {
    e.preventDefault();

    var $element = $(this);

    var action = $element.data('action');
    var url = $element.prop('href');

    if (action === 'logout') {
        $.ajax({
            url: url,
            type: 'POST',
            success: function (data, textStatus, jqXHR) {
            },
            error: function (data, textStatus, jqXHR) {
            },
            complete: function (data) {
                window.location = window.base_url;
            }
        });
    }
});