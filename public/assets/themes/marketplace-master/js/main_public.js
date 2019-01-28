$(document).ready(function () {
    initThemePublicLayoutElements();
});

$(document).ajaxComplete(function (event, xhr, settings) {
    initThemePublicLayoutElements();
});