<div id="SubNavigation">
    <div class="ContentWrapper">
        <div class="listSubNavigation">
            <a class="current" href=""><span class="Icon16 IconHome16"></span></a>
            <a href="<?php $URI->WriteURI('App=Account&Com=Profile'); ?>"><span class="Icon16 IconProfile16"></span></a>
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
<div id="Middle">
    <div class="ContentWrapper">
        <!--Content Tree Column-->
        <div class="ContentTreeLayout">

            <!--Left Column-->
            <div class="LeftColumn">

                <div class="profile">
                    <div class="avatar">
                        <?php echo $Avatar; ?>
                    </div>

                    <div class="people">
                        <a href="<?php $URI->WriteURI('App=Account&Com=Profile'); ?>" class="name"><?php echo $FirstName.' '.$LastName; ?></a>
                        <div class="ClearFix"></div>
                        <a href="<?php $URI->WriteURI('App=Account&Com=EditProfile'); ?>" class="editProfile">Edit My Profile</a>
                        <div class="ClearFix"></div>
                    </div>

                    <div class="ClearFix"></div>
                    <div class="loginInformation">
                        <div>You're logged in as <strong>student</strong></div>
                        <div>
                            Your last login:<br />
                            <strong>April 14th, 2011 at 1849</strong>
                        </div>
                    </div>

                    <div class="profileNavigation">
                        <ul>
                            <li><a class="current" href="">
                                <span class="Icon13 IconNewsFeeds13"></span>
                                <span class="label">News Feeds</span>
                            </a></li>
                            <li><a href="">
                                <span class="Icon13 IconMessage13"></span>
                                <span class="label">Messages</span>
                            </a></li>
                            <li><a href="">
                                <span class="Icon13 iconDiary13"></span>
                                <span class="label">Diaries</span>
                            </a></li>
                            <li><a href="">
                                <span class="Icon13 IconEvents13"></span>
                                <span class="label">Events</span>
                            </a></li>
                        </ul>
                        <div class="ClearFix"></div>
                    </div>

                    <div class="ClearFix"></div>
                </div>

                <div class="boxWidget">
                    <div class="header">Followers (<?php echo $CountFollowers; ?>)</div>
                    <div class="content">
                        <ul class="smallImageList">
                           <?php echo $Followers; ?>
                        </ul>
                        <div class="ClearFix"></div>
                    </div>
                </div>

                <div class="boxWidget">
                    <div class="header">Following (<?php echo $CountFollowing; ?>)</div>
                    <div class="content">
                        <ul class="smallImageList">
                            <?php echo $Following; ?>
                        </ul>
                        <div class="ClearFix"></div>
                    </div>
                </div>

            </div>

            <!--Middle Column-->
            <div class="MiddleColumn">

                <div id="NewsFeeds">
                    <h2 class="HeaderIcon">
                    <span class="Icon16 IconNewsFeeds16"></span>News Feeds
                    
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
                    </h2>
                    
                     <div id="BoxNewsFeeds">
                        <ul class="BlokNewsList" id="NotifReloaded">
                        	
                        </ul>
                        <div class="ClearFix"></div>
                        <br /><br />
                    </div>
                    
                    <?php 
                    /**
                     * <?php echo $NotifDetail; ?>
                     */
                    ?>
                    

                    <div class="ShareBox">
                        <div class="ShareTypeBox">

                            <span class="preloader Right">
                                <img src="<?php echo Path::Template("Images/ani_preloader.gif")?>" class="ShareLoading" id="ShareLoading" style="display:none;"/>
                            </span>

                        </div>
                        <div class="ClearFix"></div>

                        <div id="BoxInpuContainer">
                            <form action="" method="post">
                                <div class="BoxInput">
                                    <div class="BoxInputText">
                                        
                                        <!-- 
                                        <div id="newsFeedsShareInput" class="shareInput editable">Share something on your mind...
                                        
                                        
                                        </div>
                                       -->
                                       
                                       <textarea id="ShareStatus" rows="1" class="ShareStatus" name="ShareStatus" style="width:99%;margin-bottom:10px;">Write something on your mind...</textarea>
                                        
                                        <div class="inputAction">
                                            <a href="" class="Icon13 iconClose13"></a>
                                        </div>
                                        <ul class="ShareType">
                                            <li><a href=""><span class="Icon16 IconLink16"></span></a></li>
                                            <li><a href=""><span class="Icon16 IconQuestion16"></span></a></li>
                                            <li><a href=""><span class="Icon16 iconMap16"></span></a></li>
                                        </ul>
                                        
                                        <div class="LinkContainer" style="display:none;">
                                        <input type="text" name="LinkTextBox" id="LinkTextBox" /> 
                                        <input type="button" name="SubmitLink" id="SubmitLink" value="add" />
                                        or <a href="#">Close</a>
                                        </div>
                                        
                                        <div class="CloseFlasher" style="display:none;"><a href="#">Close Link Flasher</a></div>
                                        
                                        <div class="ClearFix"></div>
                                    </div>
                                </div>

                                <div class="BoxShareButton">
                                    <ul class="connectList">
                                        <li>Connect to :</li>
                                        <li><a href=""><span class="Icon16 iconFacebook16"></span></a></li>
                                        <li><a href=""><span class="Icon16 iconTwitter16"></span></a></li>
                                    </ul>
                                    <!--
                                    <ul class="moodList" id="moodList">
                                        <li>Your Mood :</li>
                                        <li><a href=""><span class="iconMoods iconMoodHappy " rel="iconMoodHappy"></span></a></li>
                                    </ul>
                                    <div class="moodSelectBox" id="moodSelectBox" style="display:none;">
                                        <ul class="moodList">
                                            <li><a href=""><span class="iconMoods iconMoodHappy" rel="iconMoodHappy"></span></a></li>
                                            <li><a href=""><span class="iconMoods iconMoodSad" rel="iconMoodSad"></span></a></li>
                                            <li><a href=""><span class="iconMoods iconMoodAngry" rel="iconMoodAngry"></span></a></li>
                                            <li><a href=""><span class="iconMoods iconMoodLaughing" rel="iconMoodLaughing"></span></a></li>
                                            <li><a href=""><span class="iconMoods iconMoodCrying" rel="iconMoodCrying"></span></a></li>
                                            <li><a href=""><span class="iconMoods iconMoodSick" rel="iconMoodSick"></span></a></li>
                                            <li><a href=""><span class="iconMoods iconMoodConfuse" rel="iconMoodConfuse"></span></a></li>
                                            <li><a href=""><span class="iconMoods iconMoodCool" rel="iconMoodCool"></span></a></li>
                                        </ul>
                                    </div>
                                    -->
                                    <span id="CountCharacter">
                                        Characters Left :
                                        <strong class="counter">300</strong>
                                    </span>

                                    <div class="Right">
                                        <span class="buttonBlue"><input disabled="disabled" type="submit" name="Share" id="Share" value="Share" class="button" /></span>
                                    </div>

                                    <div class="ClearFix"></div>
                                    <div class="flasher" id="flasher"></div>

                                </div>
                            </form>
                        </div>

                    </div>

                    <div class="ClearFix"></div>

                     <div id="BoxNewsFeeds">
                        <ul class="BlokNewsList" id="BlokNewsList">
                        </ul>



                        <div class="ClearFix"></div>
                        <br /><br />
                    </div>

                </div>

            </div>
            <!--End Left Column-->

            <!--Right Column-->
            <div class="RightColumn">
                <!--
                <div>
                    <div class="ProfilePictureWall">
                       <?php echo $Avatar; ?>
                    </div>

                    <div class="LoginStatus">
                        <div><a href="" class="Orange MediumFont"><?php echo $FirstName.' '.$LastName; ?></a> @<?php echo $UName; ?></div>
                        <div><a href="" class="SmallFont">Edit My Profile</a></div>

                        <div style="margin-top:23px"></div>
                        <div>You're logged in as student</div>
                        <div>Your last login:</div>
                        <div>April 14th, 2011 at 1849</div>
                    </div>
                    <div class="ClearFix"></div>
                </div>
                -->

            </div>
            <!--End Right Column-->

            <div class="ClearFix"></div>
        </div>
        <!--End Content Two Column-->
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
	
	var Educeus_Wall = (function(){

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


				var request;
				var working = false;
				var workingComment = false;
				var workingStatus = false;
				var workingSearch = false;
				
				var loadingShare = $('#ShareLoading');

				var BlokNewsList = $('#BlokNewsList');

				var LastId = '';
				var LastCommentId = '';

				var NoEnter = false;

				var SearchInput = $('#SearchInput');
				
				//var ActiveWindow = false;
				
		var init = function(){

			return $.Deferred(function(dfd){

				SearchInput.defaultText('Looking for people?');
				
			EventTextArea($('#ShareStatus'), 'Write something on your mind...');
			LoadStatus();
			scrollStatus();
			autocomplete();
			EventHandler();
			parsing();

			//ActiveWindow = true;
			
			dfd.resolve();
			}).promise();
			
		};

		var recount = function(){
			var maxlen=300;
			var current=maxlen-$('#ShareStatus').val().length;
			$(".counter").html(current);

			/*
			if (current<0 || current==maxlen){
				//$(".counter").css('color','#D40D12');
				$("input.submitbutton").attr('disabled','disabled').addClass('button');
			}else{
				$("input.submitbutton").removeAttr('disabled').removeClass('button');
			}
			*/
			if (current<0 || current==maxlen || $('#ShareStatus').val() == 'Write something on your mind...'){
				//$(".counter").css('color','#D40D12');
				$("input#Share").attr('disabled','disabled');
			}else{
				$("input#Share").removeAttr('disabled');
			}
			
			if (current<10){
				$(".counter").css('color','#D40D12');
			}else if (current<20){
				$(".counter").css('color','#5c0002');
			}else{
				$(".counter").css('color','#CCCCCC');
			}
		};

		var recount_edit = function(){
			var maxlen=300;
			var current=maxlen-$('.shareInput').text().length;
			$(".counter").html(current);
			
			if (current<0 || current==maxlen){
				//$(".counter").css('color','#D40D12');
				$("input#Share").attr('disabled','disabled');
			}else{
				$("input#Share").removeAttr('disabled');
			}
			
			if (current<10){
				$(".counter").css('color','#D40D12');
			}else if (current<20){
				$(".counter").css('color','#5c0002');
			}else{
				$(".counter").css('color','#CCCCCC');
			}
		};

		var autocomplete = function(){


			var addEvent = (function(){
				if (document.addEventListener){
					return function(el, type, fn){
						if (el && el.nodeName || el === window){
							el.addEventListener(type, fn, false);
						}else if (el && el.length){
							for(var i=0; i<el.length; i++){
								addEvent(el[i], type, fn);
							}
						}
					};
				}else{
					return function(el, type, fn){
						if (el && el.nodeName || el === window){
							el.attachEvent('on' + type, function(){
								return fn.call(el, window.event);
							});
						}else if (el && el.length){
							for(var i=0; i<el.length; i++){
								addEvent(el[i], type, fn);
							}
						}
					}
				}
			})();
			var editable = document.getElementById('editableText');
			addEvent(editable, 'blur', function(){
				document.designMode = 'off';
			});
			addEvent(editable, 'focus', function(){
				document.designMode = 'on';
			});
			
			
			// Autocomplete textarea
			$('#ShareStatus').autocomplete({
				wordCount : 1,
				mode: "outter",
				on : {
					query : function(text, cb){
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
					}
				}
			});

/*
			function getLastTextNodeIn(node) {
			    while (node) {
			        if (node.nodeType == 3) {
			            return node;
			        } else {
			            node = node.lastChild;
			        }
			    }
			}

			function isRangeAfterNode(range, node) {
			    var nodeRange, lastTextNode;
			    if (range.compareBoundaryPoints) {
			        nodeRange = document.createRange();
			        lastTextNode = getLastTextNodeIn(node);
			        nodeRange.selectNodeContents(lastTextNode);
			        nodeRange.collapse(false);
			        return range.compareBoundaryPoints(range.START_TO_END, nodeRange) > -1;
			    } else if (range.compareEndPoints) {
			        if (node.nodeType == 1) {
			            nodeRange = document.body.createTextRange();
			            nodeRange.moveToElementText(node);
			            nodeRange.collapse(false);
			            return range.compareEndPoints("StartToEnd", nodeRange) > -1;
			        } else {
			            return false;
			        }
			    }
			}

			document.getElementById("editableText").onkeydown = function(evt) {
			    var sel, range, node, nodeToDelete, nextNode, nodeRange;
			    evt = evt || window.event;
			    if (evt.keyCode == 8) {
			        // Get the DOM node containing the start of the selection
			        if (window.getSelection && window.getSelection().getRangeAt) {
			            range = window.getSelection().getRangeAt(0);
			        } else if (document.selection && document.selection.createRange) {
			            range = document.selection.createRange();
			        }
					console.log(range);
			        if (range) {
			            node = this.lastChild;
			            while (node) {
			                if ( isRangeAfterNode(range, node) ) {
			                    nodeToDelete = node;
			                    break;
			                } else {
			                    node = node.previousSibling;
			                }
			            }

			            if (nodeToDelete) {
			                this.removeChild(nodeToDelete);
			            }
			        }
			        return false;
			    }
			};
			*/
		};

		var parsing = function(){


			
			$('#SubmitLink').click(function(e){
				e.preventDefault;
//alert('aa');				
				var el = $('#LinkTextBox');

			
	
				var content = el.val();

				/*
				var url_regex = /(\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/ig;
				//var url_regex = /(http:\/\/www.|https:\/\/www.|ftp:\/\/www.|www.)([\w]+)(.[\w]+)/ig;
				var url = content.match(url_regex);

				var cekurl = false;
				var RegExp = /^(([\w]+:)?\/\/)?(([\d\w]|%[a-fA-f\d]{2,2})+(:([\d\w]|%[a-fA-f\d]{2,2})+)?@)?([\d\w][-\d\w]{0,253}[\d\w]\.)+[\w]{2,4}(:[\d]+)?(\/([-+_~.\d\w]|%[a-fA-f\d]{2,2})*)*(\?(&?([-+_~.\d\w]|%[a-fA-f\d]{2,2})=?)*)?(#([-+_~.\d\w]|%[a-fA-f\d]{2,2})*)?$/;
			    if(RegExp.test(url)){
			    	cekurl = true;
			    }

				
				if ($('#flasher').html().length > 0 && $('#flasher').text() !== 'Loading...') return false;

				if (url !== null && cekurl === true){
					
				console.log(url + "->" + url.length);
				
				$('.currentShare').stop().animate({
					'margin-left' : '130px'
				});
				
				if (url.length > 0){

					working = true;

				*/

				//url[0]
					
					$('#flasher').html('Loading...');
					var url_post = '<?php echo $URI->WriteURI('App=Account&Com=AjaxStatus&Act=ParsingURL') ?>';
					var data = {
						'url' : content,
						'status' : 1
					};
					request = $.post(url_post, data, function(res){
						if (res.status){
						var title = res.title;
						var detail = res.detail;
						var url = res.url;
						var img = res.img;
						$('#flasher').html(title+"-"+detail+"-"+url+"-"+img);
						$('.CloseFlasher').show();
						$('.LinkContainer').hide();

						if ($("input#Share").attr('disabled')){
							$("input#Share").removeAttr('disabled');
						}
						
						}else{
							$('#flasher').empty();
							$('.CloseFlasher').hide();
						}
						working = false;
					}, 'json');

				//}
				
					
				//}

				
			});



			
		};
		
		var EventHandler = function(){

			 var boxInput     = $(".BoxInputText");
				var shareInputBox = $(".shareInput", boxInput);
	            var shareInputValue = shareInputBox.text();

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
	            
			    shareInputBox.click(function() {

					var el = $(this);
			    	
				    if (!el.hasClass('ActiveBox')){
				    
	                $(this).focus();
	                //$(this).text("");

				    }
				    $('#ShareStatus').show();
			        $(this).addClass('ActiveBox');
			       // $(this).text('<a href="#">aaa</a>');
	                $(this).animate({minHeight:50}, 150, 'easeOutExpo', function() {
	                            $('.inputAction', boxInput).show();
	                            
	                        });
			    });

	            $('.iconClose13', boxInput).click(function() {
	                $('.inputAction', boxInput).hide();

	                shareInputBox.animate({minHeight:10}, 150, 'easeInBack', function() {
	                            shareInputBox.removeClass('ActiveBox');
	                            shareInputBox.text(shareInputValue);
	                        });
	                return false;
	            });

			$('.IconLink16').click(function(){

				var el = $(this);

				$('.LinkContainer').show();
				
				return false;
				
			});

			$('.LinkContainer a').click(function(){
				var el = $(this);
				el.parent().hide();
				return false;
			});

			$('.CloseFlasher a').click(function(){
				var el = $(this);
				$('#flasher').empty();
				el.parent().hide();
				if ($('#ShareStatus').val().length == 0 || 
					$('#ShareStatus').val().length === 300 ||
					$('#flasher').val().length == 0 ){
					$("input#Share").attr('disabled', 'disabled');
				}else{
					$("input#Share").removeAttr('disabled');
				}
				return false;
			});

				
			$('#ShareStatus').bind("blur focus keydown keypress keyup",function(){
				recount();
			});

			$('.shareInput').bind("blur focus keydown keypress keyup",function(){
				recount_edit();
			});

			$('#moodList').children('li').find('a').bind('click', function(){
				var el = $(this);
				var parent = el.parents('#moodList');
				var next = parent.next();
				if (next.is(':visible')){
					//alert('aa');
					next.hide();
				}else{
					//alert('bbv');
					next.show();
				}
				return false;
			});

			$('#moodSelectBox ul').children('li').bind('click', function(){
				var el = $(this);
				var n = el.find('span');
				var class1 = n.attr('class');
				var rel = n.attr('rel');
				var parent = el.parents('#moodSelectBox');
				parent.prev().children('li').eq(1).find('span').attr('class', class1);
				parent.prev().children('li').eq(1).find('span').attr('rel', rel);
				return false;
			});


			$('#Share').bind('click', function(e){
				e.preventDefault();
				alert(working);
				if (working) {
					request.abort();
					return false;
				}
				working = true;

				if ($('#ShareStatus').val().length > 300 || $('#ShareStatus').val().length == 0){
					loadingShare.hide();
					working = false;
				}
				
				loadingShare.show();	
				
				var url = '<?php echo $URI->WriteURI('App=Account&Com=AjaxStatus&Act=UpdateStatus') ?>';
				
				var DataRequest = {
						Status : $('#ShareStatus').val(),
						Emoticon : $('#moodList').children('li').eq(1).find('span').attr('rel'),
						Attachment : $('#flasher').html()
					};			

				request = $.post(url, DataRequest, function(res){
					if (res.status){

						//BlokNewsList.prepend($(res.html).hide().slideDown());

						$(res.html).hide().prependTo('#BlokNewsList').fadeIn();
						
						//Embed();
						
						$('#ShareStatus').val('');recount();
						$(".BoxInputText .ShareStatus").css("height", "15px");
                        $(".BoxInputText .ShareStatus").removeClass("Active");

                        $('#flasher').html('');

                        $('.CloseFlasher').hide();
                        
						loadingShare.hide();
						
						working = false;
						
					}
				}, 'json');
				
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
				//alert($(this).closest('.ShareContent').html());
				
				alert('aaa');
			});


			$('#Muted').live('click', function(e){
				e.preventDefault();
				var el = $(this);
				var parent = el.closest('li');
				
				var id = el.attr('rel');
				var url = '<?php echo $URI->WriteURI('App=Account&Com=AjaxFriend&Act=MutedFriend') ?>';

				var data = {'IdTeman' : id};

				 $.messageBox({
		                'title'     : 'Mute Post Confirmation',
		                'icon'      : 'iconConfirmation',
		                'message'   : 'You are about to delete this item. <br />It cannot be restored at a later time! Continue?',
		                'buttons'   : {
		                    'Mute Post'   : {
		                        'class'     : 'buttonBlue',
		                        'action'    : function() {
		                     
		            				
		                        	 $.post(url, data, function(res){
		                                 if (res.status){
		                                	 $.messageBox.hide();
		                                 	window.location = window.location;
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

				if (working) return false;
				working = true;
				
				var el = $(this);
				var parent = el.closest('li');

				var a = parent.find('#boxCommentLike');
				var cekcontainer = a.find('textarea').length;
				var isi = a.html().trim().length;
				var h = '';

				//alert(isi);
				
				var url = '<?php echo $URI->WriteURI('App=Account&Com=AjaxComment&Act=CommentContainer') ?>';

				if (cekcontainer == 0){


				var id = parent.attr('id');
					
				//$.post(url, {StatusId : parent.attr('id')}, function(r){

				var r = ''+
				'<li id="'+id+'" class="CommentContainer">' +
				'<span class="profilePicture"><?php echo $AvatarFilePath; ?>'+
            	'</span>'+
				'<span class="commentInfo">'+
            	'<form id="CommentUpload" name="CommentUpload" method="post">'+
                	'<input type="hidden" id="StatusId" name="StatusId" value="'+id+'" />'+ 	
            		'<textarea id="commentStatus" class="ShareStatus" name="commentStatus" style="height:10px;width:385px;">Write a comment...</textarea>'+
            	'</form>'+
            '</span>'+
    '</li>';	
					
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

					parent.find(".commentInfo textarea").focus();

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
                    
				//});

				}

				working = false;
				
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

				if (working) return false;
				working = true;
				
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

					working = false;
					
				}, 'json');
				
				
				
			});



			$('#likeComment').live('click', function(e){
				e.preventDefault();

				if (working) return true;
				working = true;
				
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


					working = false;
					
				}, 'json');
				
				
				
			});


			$('#CommentUpload').live('submit', function(e){
				e.preventDefault();

				if (working) return true;
				working = true;
				
				var el = $(this);
				var parent = el.closest('li');

				var url = '<?php echo $URI->WriteURI('App=Account&Com=AjaxComment&Act=UpdateComment'); ?>';
				
				$.post(url, el.serialize(), function(res){
					if (res.status){
						$(res.html).insertBefore(parent);
						el.find('textarea').val('');
					}

					working = false;
					
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

			if (working) return false;
			working = true;
			workingStatus = true;
			
			var nextStart = '';
			var url = '<?php echo $URI->WriteURI('App=Account&Com=AjaxStatus&Act=GetStatus'); ?>';


			$.when(
			
			$.post(url,{
				'start' : start
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

				LastCommentId = res.LastComment;
				
				working = false;
				workingStatus = false;
				
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
				maxWidth : 427,
				autoplay : true
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
							$(r.html).hide().prependTo(BlokNewsList).fadeIn();
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
			LastCommentId : LastCommentId,
			RealtimeTimeNotif : RealtimeTimeNotif,
			RealtimeTimeMessage : RealtimeTimeMessage
		}
		
	})();

	$.when(		
	Educeus_Wall.init()
	).done(function(){
	$(window).unbind('focus').bind('focus', function(){
	(function RealtimeStatus(){
		Educeus_Wall.RealtimeStatus(RealtimeStatus);
	})();
	(function RealtimeTimeStatus(){
		Educeus_Wall.RealtimeTimeStatus(RealtimeTimeStatus);
	})();
	(function RealtimeTimeStatusComment(){
		Educeus_Wall.RealtimeTimeStatusComment(RealtimeTimeStatusComment);
	})();
	(function RealtimeComment(){
		Educeus_Wall.RealtimeComment(RealtimeComment);
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

