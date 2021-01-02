$(function() {
    $(".node-link").on({
        mouseenter: function () {
                if ($(this).next('.node-self').next('.node-children').length) {
                    $(this).addClass("mdi-minus");
                    $(this).removeClass("mdi-checkbox-blank-circle");
                }
            
        },
        mouseleave: function () {
            $(this).addClass("mdi-checkbox-blank-circle");
            $(this).removeClass("mdi-minus");
        }
    });

    $(document).on( "click", "a.node-link", function(e) {
        e.preventDefault();
        if ($(this).next('.node-self').next('.node-children').length) {
            $(this).toggleClass("collapsed mdi-minus mdi-plus");
            $(this).next('.node-self').next('.node-children').slideToggle("slow");
        }
    });
});
