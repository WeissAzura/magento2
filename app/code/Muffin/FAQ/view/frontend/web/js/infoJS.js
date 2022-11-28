require(['jquery'],function($) {
    $(document).ready(function(){
        $(".page-title").text($(".page-title-wrapper").text());
        $(".page-title-wrapper").remove();
        $(".page-title").appendTo($(".title-wrapper"));
        $(".sidebar-additional").children().remove();
        $(".category-bar").appendTo($(".sidebar-additional"));
        $(".sidebar-additional").appendTo($(".columns"));
        $(".category-bar").children().last().css('border-bottom', 'none');
        $(".compare.wrapper").remove();
        $(".page-footer").appendTo($(".page-wrapper"));
        $(".copyright").appendTo($(".page-wrapper"));
        $(".form-toggle-button").click(function (){
            if ($(this).text() === 'Ask a Question') {
                $(this).text('Hide form');
            }
            else {
                $(this).text('Ask a Question');
            }
            $(".ask-form-container").toggle();
        });
        $(".button-container").appendTo($(".column.main"));
        $(".ask-form-container").appendTo($(".column.main"));
    });
});
