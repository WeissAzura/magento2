require(['jquery', 'Magento_Ui/js/modal/modal'],function($, modal) {
    $(document).ready(function(){
        $('body').append("<div id='modal'><div class='modal-inner-content'><span id='name-product-popup'></span><div><img src='' id='product-thumbnail-popup' alt='product image'><p id='product-price-popup'></p></div></div></div>")
        let options = {
            type: 'popup',
            responsive: true,
            title: 'Shopping cart',
            buttons: [
                {
                    text: $.mage.__('Continue shopping'),
                    click: function () {
                    this.closeModal();
                    }
                },
                {
                    text: $.mage.__('Checkout'),
                    click: function () {
                        window.location = 'http://muffin.magento.mg/checkout';
                    }
                },
                {
                    text: $.mage.__('Cart'),
                    click: function () {
                        window.location = 'http://muffin.magento.mg/checkout/cart';
                    }
                }
                ]
        };
        let popup = modal(options, $('#modal'));
        let switcher_module = false;
        if (switcher_module === true) {
            $("button[title*='Add to Cart']").attr("type", "button");
            $("button[title*='Add to Cart']").click(function (){
                const custom_url = "http://muffin.magento.mg/muffinajax/cart/add";
                $.ajax({
                    type: "POST",
                    url: custom_url,
                    data: {
                        product: $(this).closest("form").children().filter("input[name*='product']").val(),
                    },
                    dataType: 'json',
                    success: function(data) {
                        let product_image = data['image'];
                        let price = parseFloat(data['price']).toFixed(2);
                        $("#name-product-popup").text('You just added ' + data['name']);
                        $("#product-thumbnail-popup").attr('src', product_image);
                        $("#product-price-popup").text('Price: ' + price +'$');
                        $('#modal').modal("openModal");
                    },
                    error: function (xhr, status, errorThrown) {
                        console.log('Error happens. Try again.');
                        console.log(errorThrown);
                    }
                });
            });
        }
    });
});

