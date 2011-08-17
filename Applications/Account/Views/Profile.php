
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

                <div class="userProfilePicture">
                    <?php
                    $bigAvatar = ( ! empty($user->AvatarFilePath)) ? "p_big_".$user->AvatarFilePath.".jpg" : "Thumb.gif";
                    ?>
                    <img src="<?php echo Config::Instance(SETTING_USE)->photos.$bigAvatar?>" width="200" height="200" />
                </div>

                <div class="boxWidget">
                    <div class="header">Followers (<?php echo count($followers)?>)</div>
                    <div class="content">
                        <?php
                        if (count($followers) > 0) :
                            ?>
                            <ul class="mediumImageList">
                                <?php
                                foreach($followers as $follower):
                                    $avatar = ( ! empty($follower->AvatarFilePath)) ? 'p_small_'.$follower->AvatarFilePath.'.jpg' : 'thumb1.jpg';
                                    ?>
                                    <li><a title="<?php echo $follower->FirstName." ".$follower->LastName?>" href="<?php URI::WriteURI('App=Account&Com=Profile&Act=Detail&UName='.Encryption::Encrypt($follower->UName)) ?>"><img src="<?php echo Config::Instance(SETTING_USE)->photos.$avatar?>" /></a></li>
                                    <?php
                                endforeach;
                                ?>
                            </ul>
                            <?php
                        else :
                            ?>
                                <div align="center">
                                    No followers yet.
                                </div>
                            <?php
                        endif;
                        ?>
                        <div class="ClearFix"></div>
                    </div>
                </div>

                <div class="boxWidget">
                    <div class="header">Following (<?php echo count($followings)?>)</div>
                    <div class="content">
                        <?php
                        if (count($followers) > 0) :
                            ?>
                            <ul class="mediumImageList">
                                <?php
                                foreach($followings as $following):
                                    $avatar = ( ! empty($following->AvatarFilePath)) ? 'p_small_'.$following->AvatarFilePath.'.jpg' : 'thumb1.jpg';
                                    ?>
                                    <li><a title="<?php echo $following->FirstName." ".$following->LastName?>" href="<?php URI::WriteURI('App=Account&Com=Profile&Act=Detail&UName='.Encryption::Encrypt($following->UName)) ?>"><img src="<?php echo Config::Instance(SETTING_USE)->photos.$avatar?>" /></a></li>
                                    <?php
                                endforeach;
                                ?>
                            </ul>
                            <?php
                        else :
                            ?>
                                <div align="center">
                                    No followers yet.
                                </div>
                            <?php
                        endif;
                        ?>
                        <div class="ClearFix"></div>
                    </div>
                </div>

            </div>
            <div class="RightColumn">

                <div id="DetailProfile">

                    <div class="information">
                        <div class="header"><?php echo $user->FirstName.' '.$user->LastName?></div>
                        <div class="description"><?php echo $user->BriefDescription?></div>
                  	
                  	<div class="Right">
                  	<?php echo $ButtonTeman; ?>
                  	
                  	
                    
                     
                  	
                  	</div>
                  	
                    </div>
                    
                     <span class="Notif" id="MessageButton" style="
                    background-color:#CC0000;
					color:#5A0000;
					text-shadow:1px 1px 1px #E64040;
					padding:5px 10px;
					cursor:pointer;
                    "><a style="color:white;" href="<?php $URI->WriteURI('App=Account&Com=Profile&Act=Messages'); ?>"><b><?php echo $JmlMessage; ?></b> Message NoRead</a></span>
                    
                    <span class="Notif" id="NotifButton" style="
                    background-color:#CC0000;
					color:#5A0000;
					text-shadow:1px 1px 1px #E64040;
					padding:5px 10px;
					cursor:pointer;
                    "><b><?php echo $JmlNotif; ?></b> Notif</span>
                    <div id="BoxNewsFeeds">
                        <ul class="BlokNewsList" id="NotifReloaded">
                        	
                        </ul>
                        <div class="ClearFix"></div>
                        <br /><br />
                    </div>

                    <div class="tabInformation">
                        <ul class="tabInformationList">
                            <li><a class="current" href="">Posts</a></li>
                            <li><a href="<?php $URI->WriteURI('App=Account&Com=About&Act=Detail&UName='.$UName); ?>">About</a></li>
                            <li><a href="">Diaries</a></li>
                            <?php if ($user->UName == $UNameCurrent){ ?>
                            <li><a href="<?php $URI->WriteURI('App=Account&Com=EditProfile'); ?>">Edit Profile</a></li>
                        	<?php } ?>
                       	</ul>
                       	
                       	 
                       	
                        <div class="ClearFix"></div>
                    </div>

                    <div id="posts" class="tabsItemInformation">
                        <?php
                        if (count($posts) > 0) :
                            ?>
                            <ul class="BlokNewsList" id="BlokNewsList">
                               
                            </ul>
                            
                            
                            <div class="ClearFix"></div>
                        <br /><br />
                            <?php
                        else :
                            ?>
                            <div align="center">No post yet.</div>
                            <?php
                        endif;
                        ?>
                    </div>

                </div>

            </div>
        </div>

    </div>

</div>


<script type="text/javascript" src="<?php echo Path::Template('Javascripts/jquery.oembed.js')?>"></script>
<script type="text/javascript">

$(function(){

	$.fn.defaultText = function(val){
		var el = this.eq(0);
		el.data('text',val);
		el.focus(function(){
			if (el.val() == val){
				el.val('').removeClass('text');
                el.addClass('textActive');
			}
		}).blur(function(){
			if (el.val() == ''){
				el.addClass('text').val(val);
                el.removeClass('textActive');
			}
		});
		return el.blur();
	}
	
	var Educeus_Profile = (function(){

		var request;
		var working = false;

		var workingComment = false;
		var workingStatus = false;
		var workingSearch = false;

		var LastId = '';
		var LastCommentId = '';

		var NoEnter = false;

		var SearchInput = $('#SearchInput');

		var imgs = [
					<?php echo $SourceTagPicture; ?>
				];
		
				var urls = [
					<?php echo $SourceTagUName; ?>
				];

				var fullnames = [
					<?php echo $SourceTagfullname; ?>
				];

				var addtional = [
					<?php echo $SourceTagAddtional; ?>
				];
		
		var BlokNewsList = $('#BlokNewsList');

		var Follow = $('#follow');
		
		var init = function(){
			SearchInput.defaultText('Looking for people?');
			EventTextArea($('#ShareStatus'), 'Write something on your mind..');
			LoadStatus();
			scrollStatus();
			EventHandler();
		};

		var EventHandler = function(){

			$('.dtinfo').live('click', function(){
	          	var el = $(this);
	          	el.next().toggle();
	          	return false;
          	});

			$('#NotifButton').live('click', function(){
	            
	            var el = $(this);
	            var no = $('#NotifReloaded');
	            var url = '<?php echo $URI->WriteURI('App=Account&Com=AjaxStatus&Act=NotifStatus') ?>';
				//if (el.data('workingNotif')) return false;
				
				//alert('aa' + el.hasClass('Active'));
				
				el.data('workingNotif', true);
				if (!el.hasClass('Active')){
						//alert('aa');
						el.addClass('Active');
					 	$.post(url, '', function(res){
				          	if (res.status){
				            	//no.html(res.html);
				            	no.show();
				            	$(res.html).hide().appendTo(no).slideDown();
				            }
				            
				            el.data('workingNotif', false);
			            }, 'json');

				}else{
					//alert('bb');	
					el.removeClass('Active');
					no.slideUp(function(){
						$(this).empty();
					});
					 el.data('workingNotif', false);
				}
	           
            });

			Follow.live('click', function(){
				var el = $(this);
				var UName = el.data('UName');
				var AliasingName = el.data('AliasingName');
				var value = el.attr('value');
				
				if (working) request.abort();
				working = true;

				var url;var n;
				if (value == 'Follow'){
				url = '<?php echo $URI->WriteURI('App=Account&Com=AjaxFriends&Act=FollowFriend') ?>';
				n = 'Un Follow';
				}else{
				url = '<?php echo $URI->WriteURI('App=Account&Com=AjaxFriends&Act=UnFollowFriend') ?>';
				n = 'Follow';
				}
				
				var DataRequest = { 
					EDU_TOKENUNAME : UName
				};
                
				request = $.post(url, DataRequest, function(res){
					if (n == 'Un Follow'){
					    el.parent().removeClass('buttonOrange').addClass('buttonGray');
					}else{
					    el.parent().removeClass('buttonGray').addClass('buttonOrange');
					}
					el.attr('value', n);
					working = false;
					window.location = window.location;
				}, 'json');

				return false;
				
			});

			
			BlokNewsList.find('a#embedmedia').live('click', function(e){
				e.preventDefault(); 
				//embedMethod : "append",
				
				$(this).oembed(null,{
					maxWidth : 427,
					autoplay:true,
					vimeo : {autoplay:true},
					youtube : {autoplay:true}
				});
				alert('aaa');
			});

			// DELETE
			$('#DeleteStatus').live('click', function(e){
				e.preventDefault();
				var el = $(this);
				var parent = el.closest('li');

				var id = parent.attr('id');
				var jenis = el.attr('rel');

				var url;
				if (jenis === 'Status'){
				url = '<?php echo $URI->WriteURI('App=Account&Com=AjaxStatus&Act=DeleteStatus') ?>';
				}else{
				url = '<?php echo $URI->WriteURI('App=Account&Com=AjaxComment&Act=DeleteComment') ?>';
				}
				
				var data = {'IdStatus' : id};
				
				$.messageBox({
	                'title'     : 'Delete Post Confirmation ' + id,
	                'icon'      : 'iconConfirmation',
	                'message'   : 'You are about to delete this item. <br />It cannot be restored at a later time! Continue?',
	                'buttons'   : {
	                    'Delete Post'   : {
	                        'class'     : 'buttonBlue',
	                        'action'    : function() {
	                            $.post(url, data, function(res){
		                            if (res.status){
		                            	//alert(parent.prev().html());
		                            	parent.fadeOut(function(){$(this).remove();});                           	
		                            	$.messageBox.hide();
		                            	//alert(parent.parent().children('li').hasClass('CommentContainer'));
		                            	//alert(parent.parent().children('li').not('.LikeContainer, .CommentContainer').length);
		                            	//if (parent.parent().children('li').hasClass('CommentContainer') === false){
										//alert(parent.parent().children('li.CommentContainer').html());
										if (jenis !== 'Status'){
										if (parent.prev().html() === null &&
											parent.parent().children('li.CommentContainer').html() === null
											){
											parent.closest('ul').css('border-top', 'none');
											parent.closest('ul').prev().prev().hide();
										}
										}
			                            //}	
		                            }
	                            }, 'json');
	                        }
	                    },
	                    'Cancel'    : {
	                        'class'     : 'buttonGray',
	                        'action'    : function() {
	                            $.messageBox.hide();
	                        }
	                    }
	                }
	            });
				
			});

			$('#Comment').live('click', function(e){
				e.preventDefault();
				var el = $(this);
				var parent = el.closest('li');

				var a = parent.find('#boxCommentLike');
				var cekcontainer = a.find('textarea').length;
				var isi = a.html().trim().length;
				var h = '';

				//alert(isi);
				
				var url = '<?php echo $URI->WriteURI('App=Account&Com=AjaxComment&Act=CommentContainer') ?>';

				if (cekcontainer == 0){
				
				$.post(url, {StatusId : parent.attr('id')}, function(r){

					if (!isi){
						h += '<span class="arrow"></span><div class="ClearFix"></div><ul class="listReply" id="listReply"></ul>';
						a.append(h);
						a.find('#listReply').append(r);

					}else{

						//console.log(a.find('.arrow'));
						if (!a.find('.arrow')) {
							h += '<span class="arrow"></span><div class="ClearFix"></div>';
							a.append(h);
						}

						if (a.find('.arrow').is(':hidden')) {
							 a.find('.arrow').show();
							 a.find('#listReply').css('border-top', '1px solid #b8d5e1');
						}
						
						a.find('#listReply').append(r);
						
					}

					$(".commentInfo textarea").focus();

					// Autocomplete textarea comment *commentStatus
	       			 $(".commentInfo textarea").autocomplete({
	       				wordCount : 1,
	       				mode: "outter",
	       				on : {
	       					query : function(text, cb){

								NoEnter = true;
	 						
	       						if (text.indexOf('@') != -1 && text.toLowerCase().charAt(text.indexOf('@') - 1) == ''){
	       							if (text.toLowerCase().charAt(text.indexOf('@') + 1) != ''){
	       								var words = [];var img = [];var fullname = [];var additon = [];
	       						for(var i=0; i<urls.length; i++){
	       							if (
	       							urls[i].toLowerCase().indexOf(
	       							text.toLowerCase().charAt(text.indexOf('@') + 1)) == 0
	       							) {
	       								words.push(urls[i]);
	    								img.push(imgs[i]);
	    								fullname.push(fullnames[i]);
	    								additon.push(addtional[i]);
	       							}
	       						}
	       						cb(words, img, fullname, additon);
	       						}
		       						
	       						}

	       						NoEnter = false;
	       						
	       					}
	       				}
	       			});
					
					EventTextArea(a.find('#commentStatus'), 'Write a comment...');
					$(".commentInfo textarea").attr("row", 1);
                    $(".commentInfo textarea").css("height", "15px");

                    var commentText = $(".commentInfo textarea").text();
                    $(".commentInfo textarea").focus(function() {
                        if ($(this).val() == commentText) {
                            $(this).val("");
                            $(this).addClass('active');
                        }
                    }).blur(function() {
                        if ($(this).val() == "") {
                            $(this).val(commentText);
                            $(this).removeClass('active');
                        }
                    });
                    
				});

				}
				
			});

			$('#FetchingComment a').live('click', function(e){
				e.preventDefault();
				var el = $(this);
				var parent = el.parent();
				var sib = parent.siblings();
				parent.hide(function(){
					$(this).remove();
					sib.slideDown();
				});
			});

			$('#Like').live('click', function(e){
				e.preventDefault();
				var el = $(this);
				var parent = el.closest('li');
				var DataRequest = {
					IdStatus : parent.attr('id')
				};
				var a = parent.find('#boxCommentLike');
				var isi = a.html().trim().length;
				var h = '';

				var url = '<?php echo $URI->WriteURI('App=Account&Com=AjaxStatus&Act=LikesStatus') ?>';
				
				$.post(url, DataRequest, function(res){
					if (res.status){
						if (!isi){
							h += '<span class="arrow"></span><div class="ClearFix"></div><ul class="listReply" id="listReply"></ul>';
							a.append(h);
							a.find('#listReply').prepend('<li class="Likecontainer"><span class="iconLikeComment iconLike"></span><span style="font-size:11px;">You</span> like this.</li>');

						}else{

							if (a.find('#listReply').children('li').find('span').hasClass('iconLikeComment')){
								if (el.hasClass('Like')){
									a.find('.arrow').show();
									a.find('#listReply').css('border-top', '1px solid #b8d5e1');
									a.find('#listReply').children('li').eq(0).show();
									a.find('#listReply').children('li').eq(0).find('span').next().html(res.html);
								}else{
									if (!res.html.length){
									//a.find('.arrow').hide();
									
									if (a.find('#listReply').children('li').length > 1){
									a.find('#listReply').css('border-top', '1px solid #b8d5e1');
									}else{
									a.find('#listReply').css('border-top', 'none');
									a.find('.arrow').hide();
									}
									
									a.find('#listReply').children('li').eq(0).hide();
									}else{
										a.find('#listReply').children('li').eq(0).find('span').next().html(res.html);
									}
								}

							}else{

								if (a.find('#listReply')){
									a.find('#listReply').prepend('<li><span class="iconLikeComment iconLike"></span><span style="font-size:11px;">You</span> like this.</li>');
								}
								
							}

						
							
						}

						if (el.hasClass('Like')){
							el.text('Unlike');
							el.removeClass('Like');
							el.addClass('Unlike');
						}else{
							el.text('Like');
							el.removeClass('Unlike');
							el.addClass('Like');
						}
					}
				}, 'json');
				
				
				
			});



			$('#likeComment').live('click', function(e){
				e.preventDefault();
				var el = $(this);
				var parent = el.closest('li');
				var DataRequest = {
					IdStatus : parent.attr('id')
				};
				
				var url = '<?php echo $URI->WriteURI('App=Account&Com=AjaxComment&Act=LikesStatusComment') ?>';
				
				$.post(url, DataRequest, function(res){
					if (res.status){

						if (!parent.find('.countlike span').length){
							if (res.html)
							parent.find('.countlike').html('<span class="commentTime">1</span>&nbsp;people like this.');
							else
							parent.find('.countlike').html('');

							console.log(1);
							
						}else{
							if (res.html)
							parent.find('.countlike span').text(res.html);
							else
							parent.find('.countlike').html('');

							console.log(2);
							
						}
						
						if (el.hasClass('Like')){
							el.text('Unlike');
							el.removeClass('Like');
							el.addClass('Unlike');
						}else{
							el.text('Like');
							el.removeClass('Unlike');
							el.addClass('Like');
						}
					}
				}, 'json');
				
				
				
			});


			$('#CommentUpload').live('submit', function(e){
				e.preventDefault();
				var el = $(this);
				var parent = el.closest('li');

				var url = '<?php echo $URI->WriteURI('App=Account&Com=AjaxComment&Act=UpdateComment'); ?>';
				
				$.post(url, el.serialize(), function(res){
					if (res.status){
						$(res.html).insertBefore(parent);
						el.find('textarea').val('');
					}
				}, 'json');
				
			});

			$('#SearchFormContainer').submit(function(){

				var DataRequest = {
					InputCurrentUser : SearchInput.val() 
				};
				request = $.post('<?php echo $URI->WriteURI('App=Account&Com=AjaxGettingStarted&Act=GetCurrentUser') ?>', DataRequest, function(res){
					if (res.status)
					window.location = '<?php $URI->WriteURI('App=Account&Com=FindFriends'); ?>';
				}, 'json');
			
			
			return false;
		});
			
			SearchInput.bind('keyup', function(e){
				e.preventDefault();
				var el = $(this);

				var DetailList = el.next();
				var Lists = DetailList.next();
				
				if (workingSearch) request.abort();
				workingSearch = true;

				if (Lists.find('li').length > 0){
					if( e.keyCode == 40 ){//down key
						setSelected(+1, Lists);
						e.stopImmediatePropagation();
						e.preventDefault();
						return false;
					}
					if( e.keyCode == 38 ){//up key
						setSelected(-1, Lists);
						e.stopImmediatePropagation();
						e.preventDefault();
						return false;
					}
					if( e.keyCode == 27 ){
						e.stopImmediatePropagation();
						e.preventDefault();
						return false;	
					}
					if( e.keyCode == 13 ){//enter key
						var li = getCurrentSelected(Lists);
						if (li){
							e.stopImmediatePropagation();
							e.preventDefault();
							li.click();
						}
						return false;						
					}
				}

				if (el.val() == ""){
					el.val('');
					Lists.empty().hide();
					workingSearch = false;					
					return false;
				}
				
					var DataRequest = {
						InputCurrentUser : el.val() 
					};
					request = $.post('<?php echo $URI->WriteURI('App=Account&Com=AjaxGettingStarted&Act=GetCurrentUser') ?>', DataRequest, function(res){
						if (res.status){
							Lists.empty().append(res.message).show();
							$(document).bind('click', function(){

								Lists.empty().hide();
							});
							Lists.find('li').bind('click', function(){
								var _el = $(this);
								var UName = _el.data('UName');
								var AliasingName = _el.attr('data-UAliasingName');
								var FirstName = _el.attr('data-UFirstName');
								var LastName = _el.attr('data-ULastName');
								//alert(el.val());
								var linkuser = _el.attr('data-userlink');
								window.location = linkuser;
								return false;
							});
						}else{
							Lists.empty().hide();
						}
						workingSearch = false;
					}, 'json');
				
			});
			
		};


		var start = 0;
		var jmlScroll = 0;
		var LoadStatus = function(){

			if (this != window){
				if ($(this).html() == 'Loading...'){
					return false;
				}
				$(this).html('Loading...');
			}
			var nextStart = '';
			var url = '<?php echo $URI->WriteURI('App=Account&Com=AjaxStatus&Act=GetStatusProfile'); ?>';


			$.when(
			
			$.post(url,{
				'start' : start,
				'UName' : '<?php echo $UName; ?>',
			}, function(res){

				var loadMore = $('#LinkMoreUpdates').detach();
				if (!loadMore.length){
					loadMore = $('<a>', {
						id : 'LinkMoreUpdates',
						html : 'see more updates &raquo;',
						click : LoadStatus
					});
				}
			
				BlokNewsList.append(res.html);

				//Embed();
				
				
				start= res.start;

				jmlScroll++;

				BlokNewsList.next().find('#LinkMoreUpdates').remove();
				
				if (res.nextstart == 1){
					BlokNewsList.next().append(loadMore.html('see more updates &raquo;'));
				}

				
				
			}, 'json')

			).done(function(){
				LastId = BlokNewsList.children('li').eq(0).attr('id');
				//console.log(LastId);

			
				
			});
			
		};

		var scrollStatus = function(){
			
			$(window).scroll(function(){
				//console.log(jmlScroll);
				if (jmlScroll < 3){
				if ($(window).scrollTop() == $(document).height() - $(window).height()){
					LoadStatus();
				}
				}
			});
			
		};

		var Embed = function(){
			BlokNewsList.find('.fetch').oembed(null,{
				embedMethod : "append",
				maxWidth : 427
			});
		};


		var support = function(el, attr){
			var test = document.createElement(el);
			if (attr in test){
				return true;
			}else{
				return false;
			}
		};

		
		var EventTextArea = function(el, DefaultText){
			el.elastic();
			if (NoEnter === false){
			if (el.is('#commentStatus')) el.shiftenter();
			}
			if (!support('textarea', 'placeholder')){
				el
						.data('originalText', DefaultText)
						//.css('color', '#999')
						.focus(function(){
							var $el = $(this);
							if (this.value == $el.data('originalText')){
								this.value = '';
							}
						})
						.blur(function(){
							if (this.value == ""){
								this.value = $(this).data('originalText');
							}
						});
			}else{
				el
						.attr('placeholder', DefaultText)
						.text("");
			}
		};


		var RealtimeStatus = function(callback){

			if (workingStatus) return false;
			workingStatus = true;
					
			var url = '<?php echo $URI->WriteURI('App=Account&Com=AjaxStatus&Act=RealTimeGetStatus'); ?>';

			var DataRequest = {
				LastId : LastId
			};
			
			request = $.post(url, DataRequest, function(r){
				if (r.status){					
						if (r.html){
							//$(r.html).hide().prependTo(BlokNewsList).fadeIn();
							LastId = r.AwalID;
						}
				}

				LastCommentId = r.LastComment;
				
				workingStatus = false;
				
				setTimeout(callback, 5000);
				
			}, 'json');
		};

		
		
		var RealtimeComment = function(callback){

			if (workingComment) return false;
			workingComment = true;
					
			var url = '<?php echo $URI->WriteURI('App=Account&Com=AjaxComment&Act=RealtimeComment'); ?>';

			var DataRequest = {
				LastCommentId : LastCommentId
			};

			
			request = $.post(url, DataRequest, function(r){
				if (r.status){					
						if (r.html){
							var parent = r.USID;
							var html = r.html;
							var children = r.LastComment;

							if ($('li#' + parent).find('li#' + children).length === 0){
							
								if ($('li#' + parent).find('#listReply').length === 0){
	
									$('li#' + parent).find('#boxCommentLike')
									.append('<span class="arrow"></span><div class="ClearFix"></div>');
									
									var addDiv = $('<ul>',{
										id : 'listReply',
										class : 'listReply'
									});
	
									$('li#' + parent).find('#boxCommentLike').append(addDiv);
									
								}

								
								if ($('li#' + parent).find('#listReply li.CommentContainer').length == 0){
									$('li#' + parent).find('#listReply').append(html);
								}else{
									$(html).insertBefore($('li#' + parent).find('#listReply li.CommentContainer'));
								}

							LastCommentId = r.LastComment;

							}
							
						}
				}
								
				workingComment = false;
				
				setTimeout(callback, 5000);
				
			}, 'json');
		};

		var RealtimeTimeStatus = function(callback){

			BlokNewsList.children('li').each(function(){
				//console.log($(this).find('#timestatus').text());
				var el = $(this);
				var timestatus = el.find('#timestatus');
				var data = timestatus.data('timestatus');
				var r = RelativeTimePhp(data);
				timestatus.text(r);
			});

			setTimeout(callback, 5000);
			
		};

		

		var RealtimeTimeStatusComment = function(callback){

			$('.commentAction').each(function(){
				//console.log($(this).find('#timestatus').text());
				var el = $(this);
				var timestatus = el.find('#timestatuscomment');
				var data = timestatus.data('timestatus');
				var r = RelativeTimePhp(data);
				timestatus.text(r);
			});

			setTimeout(callback, 5000);
			
		};

		var workingJmlNotif = false;
		
		var RealtimeTimeNotif = function(callback){

			if (workingJmlNotif) return false;
			workingJmlNotif = true;
					
			var url = '<?php echo $URI->WriteURI('App=Account&Com=AjaxStatus&Act=RealtimeNotif'); ?>';
			
			request = $.post(url, '', function(r){
				if (r.status){					
					$('#NotifButton b').html(r.html);
				}

				workingJmlNotif = false;
				
				setTimeout(callback, 5000);
				
			}, 'json');
			
		};

		var workingJmlMessage = false;
		
		var RealtimeTimeMessage = function(callback){

			if (workingJmlMessage) return false;
			workingJmlMessage = true;
					
			var url = '<?php echo $URI->WriteURI('App=Account&Com=Profile&Act=JmlMessageRealtime'); ?>';
			
			request = $.post(url, '', function(r){
				if (r.status){					
					$('#MessageButton b').html(r.html);
				}

				workingJmlMessage = false;
				
				setTimeout(callback, 5000);
				
			}, 'json');
			
		};
		

		var RelativeTimePhp = function(pastTime){

			var os = Date.parse(pastTime);
			var cd = new Date();
			var cs = cd.getTime();
			var d = parseInt((cs - os) / 1000);
			
			if (d < 0) return false;
			if (d <= 5) return "just now";
			if (d <= 20) return "seconds ago";
			if (d <= 60) return "a minute ago";
			if (d < 3600) return parseInt(d/60) + " minute ago";
			if (d <= 1.5 * 3600) return "one hour ago";
			if (d < 23.5 * 3600) return Math.round(d/3600) + " hour ago";
			if (d < 1.5 * 24 * 3600) return "one day ago";

			if (typeof pastTime !== 'undefined')
			var dateArr = pastTime.split(' ');
			
			
			var t = '';
			if (typeof dateArr[0] !== 'undefined'){
				t += dateArr[0] + ' ';
			}
			if (typeof dateArr[1] !== 'undefined'){
				t += dateArr[1] + ' ';
			}
			if (typeof dateArr[2] !== 'undefined'){
				t += dateArr[2] + ' ';
			}
			if (typeof dateArr[3] !== 'undefined'){
				t += (dateArr[3] != cd.getFullYear() ? ' ' + dateArr[3] : '');
			}

			return t;
			
				
			
			//return dateArr[4].replace(/\:\d+$/, '') + ' ' + dateArr[2] + ' ' + dateArr[1] + (dateArr[3] != cd.getFullYear() ? ' ' + dateArr[3] : '');
			
		};

		var getCurrentSelected = function(data){
			var selected = data.find('li.activeLi');
			if (selected.length == 1) return selected;
			return null;
		};
		
		var setSelected = function(dir, data){
			var selected = data.find('li.activeLi');
			if (selected.length != 1){
				if (dir > 0){
					data.find('li:first-child').addClass('activeLi');
				}else{
					data.find('li:last-child').addClass('activeLi');
				}
				return;
			}
			selected.removeClass('activeLi');
			if (dir > 0){
				selected.next().addClass('activeLi');
			}else{
				selected.prev().addClass('activeLi');
			}
		};

		return{
			init : init,
			RealtimeStatus : RealtimeStatus,
			RealtimeComment : RealtimeComment,
			RealtimeTimeStatus : RealtimeTimeStatus,
			RealtimeTimeStatusComment : RealtimeTimeStatusComment,
			RealtimeTimeNotif : RealtimeTimeNotif,
			RealtimeTimeMessage : RealtimeTimeMessage
		}
		
	})();

	


			$.when(		
					Educeus_Profile.init()
			).done(function(){
			$(window).unbind('focus').bind('focus', function(){
			(function RealtimeStatus(){
				Educeus_Profile.RealtimeStatus(RealtimeStatus);
			})();
			(function RealtimeTimeStatus(){
				Educeus_Profile.RealtimeTimeStatus(RealtimeTimeStatus);
			})();
			(function RealtimeTimeStatusComment(){
				Educeus_Profile.RealtimeTimeStatusComment(RealtimeTimeStatusComment);
			})();
			(function RealtimeComment(){
				Educeus_Profile.RealtimeComment(RealtimeComment);
			})();
			(function RealtimeTimeNotif(){
				Educeus_Wall.RealtimeTimeNotif(RealtimeTimeNotif);
			})();
			(function RealtimeTimeMessage(){
				Educeus_Wall.RealtimeTimeMessage(RealtimeTimeMessage);
			})();
			});

			});
	
});


</script>


