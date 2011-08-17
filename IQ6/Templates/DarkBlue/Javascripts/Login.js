$(function() {
	var passwordValue;
    var usernameValue;
    
	$.EduceusLogin = $.fn.EduceusLogin = function() {};
	
	$.EduceusLogin.WindowHeight = function() {
		__SetBoxLoginPosition();	
		$(window).bind('resize', function() {
			__SetBoxLoginPosition();
		});
	};

    $.EduceusLogin.ApplyLoginForm = function() {
        var username    = $('#username');
        usernameValue   = username.val();

        username.focus(function() {
            if ($(this).val() == usernameValue) {
                $(this).val('');
                $(this).addClass('active');
            }
        }).blur(function() {
                    if ($(this).val() == '') {
                        $(this).val(usernameValue);
                        $(this).removeClass('active');
                    }
                });

        //Password
        var passwordField   = $('#password');
        passwordValue       = passwordField.val();
        passwordField.after('<input size="20" type="text" id="passwordPlaceHolder" value="'+passwordValue+'" />')

        var passwordPlaceHolder = $('#passwordPlaceHolder');
        passwordPlaceHolder.show();
        passwordField.hide();

        passwordPlaceHolder.focus(function() {
            $(this).hide();
            passwordField.show();
            passwordField.focus();
            passwordField.val('');
        });

        passwordField.blur(function () {
            if ($(this).val() == '') {
                passwordPlaceHolder.show();
                passwordField.hide();
            }
        });
    };
	
	function __SetBoxLoginPosition() {
		var windowHeight 	= $(window).height();
		var topHeader		= $("#TopLogin").height();
		var bottomFooter	= $("#BottomLogin").height();
		var mapHandler		= $(".loginMapHandler");
		var totalHeight	= windowHeight - (topHeader + bottomFooter);
        mapHandler.css("height", (totalHeight+95));
	}
	
})(jQuery);