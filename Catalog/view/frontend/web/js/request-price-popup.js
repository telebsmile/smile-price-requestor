/**
 * Smile Catalog requestPricePopup widget
 *
 * @category  Smile
 * @package   Smile\Catalog
 * @author    Tetiana Lebed <teleb@smile.fr>
 * @copyright 2019 Smile
 */
define([
    'jquery',
    'Magento_Ui/js/modal/modal',
    'mage/translate'
], function ($) {
    'use strict';

    $.widget('smile.priceRequestPopup', $.mage.modal, {
        options: {
            trigger: '[data-trigger=request_price]',
            title: $.mage.__('Request price'),
            responsive: true,
            formSelector: "#request_price_form",
            buttons: [
                {
                    text: $.mage.__('Submit Request'),
                    class: 'action primary',
                    click: function() {
                        if ($(this.options.formSelector).valid()) {
                            this.submitForm();
                        }
                    }
                }
            ]
        },

        submitForm: function() {
            var self = this;
            $.ajax({
                url: this.options.urlAjax,
                dataType: 'html',
                data: $(this.options.formSelector).serialize(),
                type: 'POST',
                loaderContext: self.options.formSelector,
                showLoader: true,
                success: function (data) {
                    $(self.options.formSelector)[0].reset();
                    self.closeModal();
                    self.showResponse(data);
                }
            });
        },

        showResponse: function (data) {
            var responseModal = $(data).modal({'autoOpen': true});
            setTimeout(function() {
                responseModal.modal('closeModal');
            }, 3000);
        }
    });
    return $.smile.priceRequestPopup;
});
