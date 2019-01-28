<script type="text/javascript">
    var category_id = $('{{ $category_field_id }}').val();
    if (category_id) {
        getAttributes(category_id);

    }

    $(document).on('change', '{{ $category_field_id }}', function () {
        var categories_ids = $(this).val();


        getAttributes(categories_ids);
    });

    function getAttributes(categories_ids) {
        if (categories_ids == null || categories_ids.length === 0) {
            categories_ids = [];
        }

        var url = '{{ url("utilities/categories/attributes") }}' + '/' + "{!!($product->exists?($product->hashed_id):'')!!}";
        $.ajax({
            type: "GET",
            url: url,
            dataType: 'json',
            data: {
                categories_ids: JSON.stringify(categories_ids),
                model_class: '{!! getObjectClassForViews($product) !!}'
            },
            success: function (data) {
                $("{{ $attributes_div }}").html(data);
            }
        });
    }
</script>