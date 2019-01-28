<script type="text/javascript">
    function filters(tableId) {
        var filters = $(tableId + "_filters" + ' .filter');

        var serialized = filters.serialize();

        return {'filters': serialized};
    }

    $(document).on('click', '.clearBtn', function (e) {
        var tableId = $(this).data('table');
        var filtersId = "#" + tableId + "_filters";

        e.preventDefault();

        $(filtersId + ' input').val("");
        $(filtersId + ' select').val("");
        $(filtersId + ' input[type="checkbox"]').val(1);
        $(filtersId + ' input[type="checkbox"]').iCheck('uncheck');

        window.LaravelDataTables[tableId].draw();
    });

    $(document).on('click', '.filterBtn', function (e) {
        e.preventDefault();

        var tableId = $(this).data('table');

        window.LaravelDataTables[tableId].draw();
    });

    $(document).on('keydown', '.filters', function (e) {
        if (e.keyCode == 13) {
            var tableId = $(this).data('table');
            window.LaravelDataTables[tableId].draw();
        }
    });

    $(".filtersCollapse").on('shown.bs.collapse', function (e) {
        var filtersCollapseHref = "#" + $(this).attr('id');
        var $filterCollapseBtn = $("a[href='" + filtersCollapseHref + "']");
        $filterCollapseBtn.html('<i class="fa fa-remove"></i>');
        $filterCollapseBtn.removeClass('btn-info');
        $filterCollapseBtn.addClass('btn-warning');
    });

    $(".filtersCollapse").on('hidden.bs.collapse', function (e) {
        var filtersCollapseHref = "#" + $(this).attr('id');
        var $filterCollapseBtn = $("a[href='" + filtersCollapseHref + "']");
        $filterCollapseBtn.html('<i class="fa fa-filter"></i>');
        $filterCollapseBtn.removeClass('btn-warning');
        $filterCollapseBtn.addClass('btn-info');
    });
</script>