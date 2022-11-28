require(['jquery'],function($) {
    $(document).ready(function(){
        $(".accordion").click(function (e){
            e.stopPropagation();
            if ($(this).hasClass('state-active')) {
                $(this).removeClass('state-active');
            } else {
                $(this).addClass('state-active');
            }
            $(this).next().slideToggle("fast");
        });
    });
});
