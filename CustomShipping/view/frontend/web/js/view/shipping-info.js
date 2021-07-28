define([
    'uiComponent',
    'ko',
    'Magento_Checkout/js/model/quote',
    'mage/url'
], function (Component, ko, quote,url) {
    'use strict';

    return Component.extend({
        defaults: {
            template: 'Chintan_CustomShipping/shipping-info'
        },

        initObservable: function () {
             this._super()
                    .observe({
                                 choices: ["choose a country","usa", "india", "uk"],
                                selectedChoice: ko.observable("choose a country")
                    });
            this.showFreeShippingInfo = ko.computed(function() 
            {
                var method = quote.shippingMethod();

                if(method && method['carrier_code'] !== undefined) {
                    if(method['carrier_code'] === 'customshipping') 
                    {
                       jQuery('div[name="shippingCustomStateCity"]').show();  
                       jQuery('#custom_shipping_div').show();
                        // Matches exactly 'tcol1'     
                        return true;
                    }
                    else
                    {
                        jQuery('div[name="shippingCustomStateCity"]').hide();   // Matches exactly 'tcol1'     
                        jQuery('#custom_shipping_div').hide(); 
                    } 
                }

                return false;

            }, this);

            this.selectedChoice.subscribe(function (newValue) 
            {
                var linkUrls  = url.build('CustomShipping/checkout/saveInQuote');
               // var url = url.build('city/checkout/saveInQuote');
               // alert("the new value is " + newValue); 
                jQuery.ajax({
                    showLoader: true,
                    url: linkUrls,
                    data: {selectedChoice : newValue},
                    type: "POST",
                    dataType: 'html'
                }).done(function (data) {
                    console.log('success');
                    jQuery("#response_state").html(data);
                    //$('div[name="shippingAddress.firstname"]').hide();

                });
            });
            return this;
        }
    });
});