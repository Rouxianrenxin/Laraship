$(document).ready(function () {
    initThemeElements();
});

$(document).ajaxComplete(function (event, xhr, settings) {
    initThemeElements();
});