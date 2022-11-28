require(['jquery'],function($) {
    $(document).ready(function(){
        $("label[data-role=minisearch-label]").click(function () {
            $(this).next().toggle();
            $("button[title=Search]").toggle();
        });
        $(document).on("click", function(event) {
            let trigger = $(".label[data-role=minisearch-label]")[0];
            let dropdown = $(".label[data-role=minisearch-label]").next();
            if (dropdown !== event.target && !dropdown.has(event.target).length && trigger !== event.target) {
                $(".label[data-role=minisearch-label]").next().hide();
                $("button[title=Search]").hide();
            }
        });
        $(".customer-button-icon").click(function () {
           $(".header_links_menu").toggle();
        });

        $(document).on("click", function(event) {
            let trigger1 = $(".customer-button-icon")[0];
            let dropdown1 = $(".header_links_menu");
            if (dropdown1 !== event.target && !dropdown1.has(event.target).length && trigger1 !== event.target) {
                $(".header_links_menu").hide();
            }
        });
        $(".category-item").on("category-item:active", function (event)  {
            if ($(this).is(".active") && $(this).hasClass("has-active") === false && $(this).hasClass("parent") === false && $(this).hasClass("level-top") === false) {
                $(this).children().css("color","#ff0000");
            }
            else if ($(this).hasClass("active") && $(this).hasClass("level0") && $(this).hasClass("level-top")) {
                $(this).children().css("color","#9d8c89");
            }
        });
        $(".category-item").trigger("category-item:active");
    });
});
