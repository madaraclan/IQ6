/**
 * Custom Message Box
 * User: Iqbal Maulana
 * Date: 6/16/11
 * Time: 1:08 AM
 */

$(function($) {
    $.messageBox = function(params) {
        if ($("#messageBoxOverlay").length) return false;

        var buttonHTML = '';
        $.each(params.buttons, function(name, obj) {
            if ( ! obj['type'] || obj['type'] == 'undefined') obj['type'] = 'button';

            buttonHTML += '<span class="'+obj['class']+'"><input type="'+obj['type']+'" name="'+obj['name']+'" value="'+name+'" class="button" /></span>';

            if ( ! obj.action) obj.action = function() {};
        });

        if (buttonHTML) {
            buttonHTML = '<div class="buttonContent"><div class="buttonPosition">' + buttonHTML + '</div><div class="ClearFix"></div></div>';
        }

        var markup = [
            //'<div id="messageBoxOverlay">',

            //Box Header
            '<div class="popupBox">',
            '<div class="top">',
            '<div class="leftTop bgX">',
            '<div class="rightTop bgX">',
            '<div class="centerTop bgX">',
            '<div class="title">', params.title , '</div>',
            '</div></div></div></div>',

            //Box Content
            '<div class="content">',
            '<div class="leftMidle bgY">',
            '<div class="rightMidle bgY">',
            '<div class="centerMidle">',
            '<div class="boxContent">',
            '<div class="iconMessageBox ', params.icon, '"></div>',
            '<div class="messageContent">', params.message, '</div>',
            '<div class="ClearFix"></div>', buttonHTML, '</div>',
            '</div></div></div></div>',

            //Box Footer
            '<div class="bottom">',
            '<div class="bottomLeft bgX">',
            '<div class="bottomRight bgX">',
            '<div class="bottomCenter bgX"></div>',
            '</div></div></div></div>'

            //'</div>'

        ].join('');
        $('<div id="messageBoxOverlay"></div>').appendTo('body');
        $(markup).hide().appendTo('body');
        var top     = $(".popupBox").height() / 2;
        var left    = $(".popupBox").width() / 2;

        $(".popupBox").css({marginTop:-top+'px', marginLeft:-left+'px'});
        $(".popupBox").fadeIn(function() {
            $("#messageBoxOverlay").fadeIn("slow", function() {
                $("#messageBoxOverlay").css({opacity:'0.5'});
            });

        });
        
        var buttons = $(".buttonPosition span");
        i = 0;

        $.each(params.buttons, function(name, obj) {
            buttons.eq(i++).click(function() {
                obj.action();
                return false;
            });
        });
    }

    $.messageBox.hide = function() {
        $("#messageBoxOverlay").fadeOut(function() { $(this).remove(); });
        $(".popupBox").fadeOut(function(){ $(this).remove(); });
    }

});