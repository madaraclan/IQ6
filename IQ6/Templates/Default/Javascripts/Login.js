$(function() {
	
	$.EduceusLogin = $.fn.EduceusLogin = function() {};
	
	$.EduceusLogin.SetBoxLoginPosition = function() {
		__SetBoxLoginPosition();	
		$(window).bind('resize', function() {
			__SetBoxLoginPosition();
		});
	};
	
	function __SetBoxLoginPosition() {
		var windowHeight 	= $(window).height();
		var topHeader		= $("#Top").height();
		var bottomFooter	= $("#BottomWrapper").height();
		var loginBox		= $("#LoginBox").height();
		
		var middleContent	= windowHeight - (topHeader + bottomFooter);
		var margin			= (middleContent - loginBox) / 2;
		
		margin -= 5;
		$("#LoginBox").css({marginTop:margin+'px', marginBottom:margin+'px'});
	}
	
})(jQuery);