
<div id="SubNavigation">
    <div class="ContentWrapper">
        <div class="listSubNavigation">
            <a class="" href="<?php $URI->WriteURI('App=Account&Com=NewsFeeds'); ?>"><span class="Icon16 IconHome16"></span></a>
            <a class="current" href="<?php $URI->WriteURI('App=Account&Com=Profile'); ?>"><span class="Icon16 IconProfile16"></span></a>
            <a href="<?php $URI->WriteURI('App=Account&Com=FindFriends&Act=Search'); ?>"><span class="Icon16 IconFriends16"></span></a>
        </div>
        <div class="QuickSearchContainer">
            <span class="QuickSearch">
                <form method="post" action="" id="SearchFormContainer">
                    <input type="text" id="SearchInput" name="quickFind" value="" autocomplete="off" />
                    <div class="DetailList" style="display:none; margin: -21px 0 0 1px; height: 13px"><a href="#" id="RemoveList">X</a></div>
	                        <ul class="ListAutoComplete ListFindName" id="ListFindName" style="display:none; padding: 0; margin: 0;">
	                    	</ul>
                </form>
            </span>
        </div>
    </div>
</div>

<div id="Middle" >

    <div class="ContentWrapper">

        <div class="ContentTwoLayout">
            <div class="LeftColumn">


            </div>
            <div class="RightColumn"
            style=""
            >
				
				<div class="FixedArea">
				
				<div class="FixedHeader">
				
				<h2>Messages</h2>
				
				<div class="uibutton-toolbar" id="buttongroup"
				>
					<a href="#" class="uibutton" id="newmessages">New Messages</a>
				</div>
				
				<div class="clear" style="clear:both;"></div>
				
				<div class="dialogcontent" id="formSendMessagePer" style="display:none;">
					
					<h2></h2>
					
					<form class="sendForm" style="margin-top:10px;">
						<input type="hidden" name="idmessageReply" id="idmessageReply" value="" />
						<input type="hidden" name="IsRead" id="IsRead" value="1" />
						<textarea class="uitextarea" id="edit-messageReply" style="width:451px;"></textarea>		
						<input type="submit" name="share" id="SendMessagesReply" class="uibutton confirm" value="Send" style="display:block;" />
					</form>
				</div>
				
				</div>
				
				<div class="messageslist" id="messageslist">
					<ul>
						<?php echo $GetMessage; ?>
					</ul>
				</div>
			
			</div>	
				
            </div>
            
            </div>
            
        </div>

    </div>

</div>

		<div class="dialogcontainer" id="dialogMessages" style="display:none;">
			<div class="dialog">
				<div class="dialogheader">
					<h3>Messages</h3>
					<div class="dialogclose" id="dialogclose">
						<b>X</b>
					</div>
				</div>
				<div class="dialoginside">
					<div class="dialogbody">
						<div class="dialogcontent">
							<form class="shareform" method="post" style="margin-top:10px;">
								
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		
		<div id="message-drawer" style="display:none;">
		<div class="message error">
		<div class="message-inside">
			<span></span>
			<a href="#" class="dismiss" id="dismiss">X</a>
		</div>
		</div>
		</div>
		
<script src="<?php echo Path::Template('Javascripts/chosen/chosen.jquery.js')?>" type="text/javascript"></script>		
		
<script type="text/javascript">

$(function(){

var Messages = (function(){

	var d = $('#dialogMessages');
	
	var formMessages = ''+
	'<select data-placeholder="Select Friends" style="width:477px;" id="edit-friends" multiple class="chzn-select" tabindex="8">' +
		 '<option value=""></option><?php echo $OptionName; ?>' +
		 '' +
		'</select>' +
		'<textarea class="uitextarea" id="edit-message" style="width:451px;"></textarea>' +
		'<input type="submit" name="share" id="SendMessages" class="uibutton confirm" value="Send" />';

	var SelectChosen = function(){
		$('.chzn-select').chosen().change(function(){
			console.log($(this).val());
		});
	};
	var SendWorkingWorking = false;
	var workingBackMessageReply = false;

	var LastId, IdMessage;

	var TR;
	
	var EventHandler = function(){
		$('#newmessages').live('click', function(){
			var el = $(this);
			d.fadeIn(function(){
				d.find('.shareform').append(formMessages);
				SelectChosen();
			});
			return false;
		});
		$('#dialogclose').live('click', function(){
			d.find('.shareform').empty();
			d.hide();
			return false;
		});

		
		$('#SendMessages').live('click', function(){
			
			var el = $(this);
			var s_f = $('#edit-friends');
			var e_m = $('#edit-message');
			var FriendValue = s_f.val();
			var MessageValue = e_m.val();
			var data = {to:FriendValue, content:MessageValue, Status:'Read'};
			var url = '<?php echo $URI->WriteURI('App=Account&Com=Profile&Act=SendMesage'); ?>';

			if (SendWorkingWorking) return false;
			SendWorkingWorking = true;

			if (MessageValue.length < 1 || FriendValue.length < 1){
				$('#message-drawer').fadeIn(function(){
					$('.message-inside span').html('Error!');
				});

				SendWorkingWorking = false;
				
			}else{
			
			$.post(url, data, function(res){
				if (res.status){
					$('#message-drawer').fadeIn(function(){
						$('.message-inside span').html('Message send!');
					});
				}

				$('#dialogclose').click();
				SendWorkingWorking = false;

				$('.messageslist').find('ul').prepend(res.Message);
				
			}, 'json');

			}
			return false;
		});

		var workingSendMessage = false;
		$('.messageslist li a').live('click', function(){
			if (workingSendMessage) return false;
			workingSendMessage = true;
			var el = $(this);
			var idmessage = el.data('idmessage');
			var data = {idmessage:idmessage};
			var url = '<?php echo $URI->WriteURI('App=Account&Com=Profile&Act=DetailMessage'); ?>';
			$('.messageslist').find('ul').html('Loading...');
			$.post(url, data, function(res){
				workingSendMessage = false;
				$.when(
					DataDetail(res)
				).done(function(){

					
					(function getRealtimeMessages(){
					$.when(
						DataDetailProp($('#messagelistReply').find('ul li:first').data('idmessagereply'), res.IdMessage)
					).done(function(){
						
							RealtimeMessages(getRealtimeMessages);
						
					});
					})();
					
				});
				
			}, 'json');
			return false;
		});

		var workingBackMessage = false;
		$('#backmessage').live('click', function(){
			if (workingBackMessage) return false;
			workingBackMessage = true;
			var el = $(this);
			var url = '<?php echo $URI->WriteURI('App=Account&Com=Profile&Act=GetMessage'); ?>';
			$('.messageslist').find('ul').html('Loading...');
			$.post(url, '', function(res){

				$('#formSendMessagePer').hide();
				$('#buttongroup').find('#backmessage').remove();

				$('#formSendMessagePer').find('#idmessageReply').val('');
				LastId = IdMessage = '';
				clearTimeout(TR); TR = '';
				
				$('#messagelistReply').attr('id', 'messageslist');
				
				if (res.status)
					$('#messageslist').find('ul').html(res.html);

				
				workingBackMessage = false;
			}, 'json');
			return false;
		});


		$('#dismiss').live('click', function(){
			$('#message-drawer').fadeOut(function(){
				$('.message-inside span').empty();
			});
			return false;
		});

		
		$('#SendMessagesReply').live('click', function(){
			var el = $(this);
			var IdMessageReply = $('#idmessageReply').val();
			var MessageReplyText = $('#edit-messageReply').val();
			var IsRead = $('#IsRead').val();

			if (!IdMessageReply.length || !MessageReplyText.length){
				$('#message-drawer').fadeIn(function(){
					$('.message-inside span').html('Error!');
				});
				return false;
			}

			if (workingBackMessageReply) return false;
			workingBackMessageReply = true;

			var data = {
					IdMessageReply : IdMessageReply, 
					MessageReplyText : MessageReplyText,
					IsRead : IsRead
			};
			var url = '<?php echo $URI->WriteURI('App=Account&Com=Profile&Act=SendMessageDetail'); ?>';

			$.post(url, data, function(res){
				if (res.status)
					$(res.html).hide().prependTo($('#messagelistReply').find('ul')).slideDown();

				$('#edit-messageReply').val('');
				workingBackMessageReply = false;
			}, 'json');
			
			return false;
		});

		$(window).scroll(UpdateTableHeader);
		
	};

	var RealtimeMessages = function(callback){
		var data = {LastId : LastId, IdMessage : IdMessage};
		console.log(LastId + "->" + IdMessage);
		var url = '<?php echo $URI->WriteURI('App=Account&Com=Profile&Act=GetMessageDetailRealtime'); ?>';
		$.post(url, data, function(res){
			$(res.html).hide().prependTo($('#messagelistReply').find('ul')).slideDown();
			TR = setTimeout(callback,2000);
		}, 'json');
	};

	var DataDetail = function(res){
		$('.messageslist').attr('id', 'messagelistReply');
		$('#formSendMessagePer h2').html(res.TitleMessage);
		$('#messagelistReply').find('ul').html(res.DetailMessage);

		$('#formSendMessagePer').find('#idmessageReply').val(res.IdMessage);
		
		$('#formSendMessagePer').show();
		$('#buttongroup').append('<a href="#" class="uibutton" id="backmessage">Back to message</a>');

		var clonedHeaderRow = $('.FixedHeader');
		$('.floatingHeader').html(clonedHeaderRow.html());
		
	};

	var DataDetailProp = function(p1, p2){
		LastId = p1;
		IdMessage = p2;
	};
	
	var init = function(){
		EventHandler();
		FixedHeader();
		UpdateTableHeader();
	};

	var FixedHeader = function(){

		$('.FixedArea').each(function(){
			$(this).wrap('<div class="relativeContainer"></div>');
			var clonedHeaderRow = $('.FixedHeader', this);
			clonedHeaderRow
			.before(clonedHeaderRow.clone())
			.css('width', clonedHeaderRow.width())
			.addClass('floatingHeader')
			;
		});

		
		
	};

	var UpdateTableHeader = function(){
		$('.relativeContainer').each(function(){
			var el = $(this);
			var offset = el.offset();
			var scrollTop = $(window).scrollTop();
			var floatingHeader = $('.floatingHeader', this);
			if ( (scrollTop > offset.top) && (scrollTop < offset.top + el.height())){
				floatingHeader.css({
					visibility : 'visible'
				});
			}else{
				floatingHeader.css({
					visibility : 'hidden'
				});
			}
		});
	};

	return {
		init : init
	}
	
})();

Messages.init();

});



</script>