(function($){
	
	$.fn.CheckBox = function(options){
		
		options = $.extend({
			labels : ['ON', 'OFF']
		}, options);
		
		return this.each(function(){
			var originalCheckBox = $(this);
			var labels = [];
			
			if (originalCheckBox.data('on')){
				labels[0] = originalCheckBox.data('on');
				labels[1] = originalCheckBox.data('off');
			}else{
				labels = options.labels;
			}
			
			var checkbox = $('<span>', {
				className : 'CheckBox ' + (this.checked ? 'checked' : ''),
				html : '<span class="CheckBoxContent">'+labels[this.checked ? 0 : 1]+'</span>'+
					   '<span class="CheckBoxPart"></span>'
			});
			
			checkbox.insertAfter(originalCheckBox.hide());
			
			checkbox.click(function(){
				checkbox.toggleClass('checked');
				var isChecked = checkbox.hasClass('checked');
				originalCheckBox.attr('checked', isChecked);
				checkbox.find('.CheckBoxContent').html(labels[isChecked ? 0 : 1]);
			});
			
			originalCheckBox.bind('change', function(){
				checkbox.click();
			});
			
		});
		
	}
	
})(jQuery);