(function ($) {

    $('#vc_ui-panel-edit-element').on('vcPanel.shown', function () {
        $('.woodmart-vc-image-select').each(function () {
            var $select = $(this);
            var $input = $select.find('.woodmart-vc-image-select-input');
            var inputValue = $input.attr('value');
            $select.find('li[data-value="' + inputValue + '"]').addClass('xts-active');
            $select.find('li').click(function () {
                var $this = $(this),
                    dataValue = $this.data('value');

                $this.siblings().removeClass('xts-active');
                $this.addClass('xts-active');
                $input.attr('value', dataValue).trigger('change');
            });
        });
    });

})(jQuery);
