;(function ($) {
    $('.streak-product-images .variations li:first-of-type').addClass('current');

    $('.streak-product-images').on('variation', function(ev, data) {
        $('li', $(this)).removeClass('current');
        $('li[data-id="' + data + '"]', $(this)).addClass('current');
    });
    $('select.attribute_option.dropdown').on('change', function() {
        $('.streak-product-images').trigger('variation', $(this).val());
    });
    // update order form when button is clicked
    $('.order-form input.update-order').click(function () {
        $('.order-form').entwine('sws').updateCart();
    });
})(jQuery);

