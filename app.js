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

    $(document).on( "click", "a.node-link", function(event) {
        event.preventDefault();
        if ($(this).next('.node-self').next('.node-children').length) {
            $(this).toggleClass("collapsed mdi-minus mdi-plus");
            $(this).next('.node-self').next('.node-children').slideToggle("slow");
        }
    });

    $(document).on( "keyup", ".node-line", function(event) {
        var keycode = event.charCode || event.keyCode;
        if (keycode == 13) { //Enter key's keycode
            var closestNode = jQuery(this).closest(".node-self");
            jQuery('<div class="node-self"><a class="node-link bullet mdi mdi-checkbox-blank-circle" tabindex="-1" href="#"></a><div class="node-line" contenteditable="true"></div></div>').insertAfter(closestNode).focus();
            return false;
        }
    });

});
