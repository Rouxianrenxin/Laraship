$(function () {
    $(document).on('click', '.show_announcement', function () {
        event.preventDefault();

        var title = $(this).data('title');
        var view_url = $(this).attr('href');

        var hashed_id = _.last(_.split(view_url, '/'));

        $.get(view_url, function (data) {
            $.magnificPopup.open({
                items: {
                    src: data,
                    type: 'inline'
                },
                closeOnContentClick: false,
                closeBtnInside: false,
            });
        });
    });

    $(document).ready(function () {
        // add this code after popup JS file is included
        $.magnificPopup.instance.next = function () {
            let read_url = this.currItem.data.read_url;
            let element = this;

            if (!element.currItem.data.read) {
                $.ajax({
                    url: read_url,
                    type: 'GET',
                    beforeSend: function (xhr) {
                        xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
                    },
                    global: false,
                    success: function (data, textStatus, jqXHR) {
                        element.currItem.data.read = true;
                    }
                });
            }

            // You may call parent ("original") method like so:
            $.magnificPopup.proto.next.call(element /*, optional arguments */);
        };

        $.magnificPopup.instance.prev = function () {
            let read_url = this.currItem.data.read_url;
            let element = this;

            if (!element.currItem.data.read) {
                $.ajax({
                    url: read_url,
                    type: 'GET',
                    beforeSend: function (xhr) {
                        xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
                    },
                    global: false,
                    success: function (data, textStatus, jqXHR) {
                        element.currItem.data.read = true;
                    }
                });
            }

            // You may call parent ("original") method like so:
            $.magnificPopup.proto.prev.call(element /*, optional arguments */);
        };

        setTimeout(function () {
            let checkUnreadAnnouncements = window.base_url + '/announcements/unread-in-url';
            let currentURL = location.pathname;

            $.ajax({
                url: checkUnreadAnnouncements,
                data: {current_url: currentURL},
                type: 'GET',
                beforeSend: function (xhr) {
                    xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
                },
                global: false,
                success: function (data, textStatus, jqXHR) {
                    if (!data.length) {
                        return false;
                    }

                    $.magnificPopup.open({
                        items: data,
                        closeOnContentClick: false,
                        closeBtnInside: false,
                        gallery: {
                            enabled: true
                        }
                    });
                }
            });
        }, 500);
    });
});