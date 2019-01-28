<script type="text/javascript">
    $(function () {
        $('.btn-radio').click(function (e) {
            $('.btn-radio').not(this).removeClass('active btn-success')
                .siblings('input').prop('checked', false)
                .siblings('.img-radio').parent('div').removeClass('selected-radio');
            $(this).addClass('active btn-success')
                .siblings('input').prop('checked', true)
                .siblings('.img-radio').parent('div').addClass('selected-radio');
        });
    });

    function updateCart(response) {
        if (response.level === "success" || response.level === "warning") {

            if (response.itemhash && response.quantity) {
                $('#item-' + response.itemhash + ' .cart-quantity').val(response.quantity);
            }


            if (response.action == "removeItem") {
                $('#item-' + response.itemhash).fadeOut("normal", function () {
                    $(this).remove();
                });
            } else if (response.item_total) {

                $('#item-total-' + response.itemhash).html(response.item_total);

            }
            if (response.empty == true) {
                location.reload();
            } else {
                $('#total').html(response.total);
                $('#cart-header-total').html(response.total);
                $('#cart-header-count').html(response.cart_count);
            }
        }

    }

    (function () {
        $('.cart-quantity').on('change', function () {
            $(this).closest('form').submit();
        });
    })();
</script>