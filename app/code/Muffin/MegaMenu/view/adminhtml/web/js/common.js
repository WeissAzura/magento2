require(['jquery'],function($) {
    $(document).ready(function(){
        $("body").on('DOMNodeInserted', '[name=category_id]', function (e) {
            $("[name=category_id]").change(function (e){
                if ($(this).val() === 'New' ) {
                    $('[data-index=cat_name]').show();
                    $("[data-index=cat_url]").show();
                }
                else {
                    $('[data-index=cat_name]').hide();
                    $("[data-index=cat_url]").hide();
                }
            });
        });
        $("body").on('DOMNodeInserted', '[name=menu_type]', function (e) {
            $("[name=menu_type]").change(function (e){
                if ($(this).val() === '1' ) {
                    $('[data-index=cat_name]').hide();
                    $("[data-index=cat_url]").hide();
                    $("[data-index=cat_url]").next().hide();
                    $("[name=category_id]").val('');
                }
                else {
                    $("[data-index=cat_url]").next().show();
                }
            });
        });
    });
});
