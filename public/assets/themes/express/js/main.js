$(document).ready(function () {
    initThemeElements();
});

function logout() {
    $.ajax({
        url: '/logout',
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