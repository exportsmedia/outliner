$(function() {
    $(".node-link").on({
        mouseenter: function () {
                if ($(this).closest('.node-self').next('.node-children').length) {
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
        if ($(this).closest('.node-self').next('.node-children').length) {
            $(this).toggleClass("collapsed mdi-minus mdi-plus");
            $(this).closest('.node-self').next('.node-children').slideToggle("slow");
        }
    });

    $(document).on( "keydown", ".node-line", function(event) {
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if (keycode == '13') { //Enter key's keycode
            event.preventDefault();
            var closestNode = jQuery(this).closest(".node-self");
            var markup = '<div class="node node-self"><a class="node-link bullet mdi mdi-checkbox-blank-circle" tabindex="-1" href="#"></a><div class="node-line" contenteditable="true"></div></div>';
            jQuery(markup).insertAfter(closestNode);
            jQuery(closestNode).next(".node-self").find(".node-line").trigger('focus');
            return false;
        }
        if (keycode == '9' && !event.shiftKey) { //Tab key's keycode
            event.preventDefault();
            var closestNode = jQuery(this).closest(".node-self");
            if (closestNode.prev('.node-self').length == 0 && closestNode.prev('.node-children').length == 0) {
               return false;
            } else {
                $( closestNode ).wrap( '<div class="node node-children"></div>' );
                jQuery(closestNode).find(".node-line").trigger('focus');
            }
            return false;
        } 
        if ((keycode == '9' && event.shiftKey)) { //Tab + Shift key's keycode
            event.preventDefault();
            var closestNode = jQuery(this).closest(".node-self");
            if (closestNode.parents('.node-children').length) {
                $(closestNode).insertAfter(closestNode.parents('.node-children').first())
            }
            jQuery(closestNode).find(".node-line").trigger('focus');
            return false;
        } 
    });
    $(document).on( "keyup", ".node-line", function(event) {
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if (keycode == '46' || keycode == '8') { //Delete key's keycode
            event.preventDefault();
            if ($(this).text().trim().length == 0) {
                var selected = jQuery(this).closest(".node-self").prev(".node-self").find(".node-line").last();
                if(selected.length == 0) {
                    selected = jQuery(this).closest(".node-self").next(".node-self").find(".node-line").last();
                }
                if(selected.length == 0) {
                    selected = jQuery(this).closest(".node-self").prev().find(".node-line").last();
                }
                if(selected.length == 0) {
                    selected = jQuery(this).closest(".node-children").prev().find(".node-line").last();
                }
                $(selected).trigger('focus');
                $(selected).addClass('found-next');
                setEndOfContenteditable($(selected)[0]);
                jQuery(this).closest(".node-self").remove();
            }
            return false;
        }
    });


    // Moves cursor to the end of the content editable field
    // https://stackoverflow.com/a/56556883/8034588
    function setEndOfContenteditable(contentEditableElement) {
        var range,selection;
        if(document.createRange)//Firefox, Chrome, Opera, Safari, IE 9+
        {
            range = document.createRange();//Create a range (a range is a like the selection but invisible)
            range.selectNodeContents(contentEditableElement);//Select the entire contents of the element with the range
            range.collapse(false);//collapse the range to the end point. false means collapse to end rather than the start
            selection = window.getSelection();//get the selection object (allows you to change selection)
            selection.removeAllRanges();//remove any selections already made
            selection.addRange(range);//make the range you have just created the visible selection
        }
        else if(document.selection)//IE 8 and lower
        { 
            range = document.body.createTextRange();//Create a range (a range is a like the selection but invisible)
            range.moveToElementText(contentEditableElement);//Select the entire contents of the element with the range
            range.collapse(false);//collapse the range to the end point. false means collapse to end rather than the start
            range.select();//Select the range (make it the visible selection
        }
    }


    function debounce(callback, wait) {
        let timeout;
        return (...args) => {
            clearTimeout(timeout);
            timeout = setTimeout(function () { callback.apply(this, args) }, wait);
        };
    }

    window.addEventListener('keyup', debounce( () => {

        var content = document.querySelectorAll(".outline-content");
        var nodeArray = autoSaveContent(content);
        console.log(nodeArray)
        // code you would like to run 1000ms after the keyup event has stopped firing
        // further keyup events reset the timer, as expected
    }, 3000))

    function autoSaveContent(content) {
        var nodeArray = [];
        var count = 0;
        for (var i = 0; i < content.length; i++) {
            if (content[i].classList.contains("outline-content")) {
                nodeArray = autoSaveContent(content[i].children);
            } else if (content[i].classList.contains("node-children")) {
                nodeArray[count - 1]["children"] = autoSaveContent(content[i].children);
            } else if (content[i].classList.contains("node-self")) {
                nodeArray[count] = {
                    "link": content[i].querySelector(".node-link").getAttribute("href"),
                    "line": content[i].querySelector(".node-line").innerHTML,
                };
                count++;
            }
        }
        return nodeArray;
    };

});
